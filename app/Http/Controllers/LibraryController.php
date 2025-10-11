<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use App\Models\UserBook;
use App\Models\UserShelf;
use App\Models\UserShelfItem;
use App\Models\UserCategory;

class LibraryController extends Controller
{
    /**
     * Helper function to get authors as string
     */
    private function getAuthorsAsString($authors)
    {
        if (is_array($authors)) {
            return implode(', ', $authors);
        }
        return $authors ?? '';
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $searchQuery = $request->get('search', '');
        $shelfSlug = $request->get('shelf', 'all');
        
        // Get user's shelves with book counts
        $shelves = $user->shelves()->with('items')->get()->map(function($shelf) {
            return [
                'id' => $shelf->slug,
                'name' => $shelf->name,
                'icon' => $shelf->icon,
                'color' => $shelf->color,
                'count' => $shelf->items->count(),
                'is_system' => $shelf->is_system
            ];
        });
        
        // Get books based on shelf selection
        if ($shelfSlug === 'all') {
            // Get all user books
            $query = $user->userBooks()->with(['book']);
        } else {
            // Get books from specific shelf
            $shelf = $user->shelves()->where('slug', $shelfSlug)->first();
            if (!$shelf) {
                return redirect()->route('library');
            }
            
            $bookIds = $shelf->items()->pluck('book_id');
            $query = $user->userBooks()->with(['book'])->whereIn('book_id', $bookIds);
        }
        
        // Filter by search query
        if (!empty($searchQuery)) {
            $query->whereHas('book', function($q) use ($searchQuery) {
                $q->where('title', 'ilike', "%{$searchQuery}%")
                  ->orWhereRaw("authors::text ilike ?", ["%{$searchQuery}%"]);
            });
        }
        
        $userBooks = $query->get();
        
        // Add shelf information to each book
        $userBooks = $userBooks->map(function($userBook) use ($user) {
            $shelfItems = \App\Models\UserShelfItem::where('user_id', $user->id)
                ->where('book_id', $userBook->book_id)
                ->with('shelf')
                ->get();
            $userBook->userShelves = $shelfItems->pluck('shelf');
            return $userBook;
        });

        return view('pages.library', compact('user', 'userBooks', 'shelves', 'searchQuery', 'shelfSlug'));
    }

    public function addBook(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|string',
                'book_source' => 'required|string',
                'book_title' => 'required|string',
                'book_authors' => 'nullable|string',
                'book_image' => 'nullable|string',
                'book_description' => 'nullable|string',
                'book_publisher' => 'nullable|string',
                'book_published_date' => 'nullable|date',
                'book_page_count' => 'nullable|integer',
                'book_isbn' => 'nullable|string',
                'book_rating' => 'nullable|numeric|between:0,5',
                'book_categories' => 'nullable|string',
                'book_preview_url' => 'nullable|url',
                'book_info_url' => 'nullable|url',
                'category' => 'nullable|string|in:to-read,reading,read,favorites,wishlist',
                'notes' => 'nullable|string|max:1000'
            ]);

            $user = Auth::user();
            
            // Check if book already exists in database
            $book = Book::where('external_id', $request->book_id)
                       ->where('source', $request->book_source)
                       ->first();
            
            // If book doesn't exist, create it
            if (!$book) {
                $book = Book::create([
                    'external_id' => $request->book_id,
                    'source' => $request->book_source,
                    'title' => $request->book_title,
                    'authors' => $request->book_authors ? explode(', ', $request->book_authors) : [],
                    'description' => $request->book_description,
                    'publisher' => $request->book_publisher,
                    'published_date' => $request->book_published_date,
                    'page_count' => $request->book_page_count,
                    'isbn' => $request->book_isbn,
                    'rating' => $request->book_rating,
                    'categories' => $request->book_categories ? explode(', ', $request->book_categories) : [],
                    'cover_url' => $request->book_image,
                    'preview_url' => $request->book_preview_url,
                    'info_url' => $request->book_info_url,
                ]);
            }
            
            // Check if user already has this book
            $existingUserBook = UserBook::where('user_id', $user->id)
                                       ->where('book_id', $book->id)
                                       ->first();
            
            if ($existingUserBook) {
                return redirect()->back()->with('error', __('app.books.messages.already_added'));
            }
            
            // Add book to user's library
            UserBook::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'status' => $request->category ?? 'to-read',
                'notes' => $request->notes,
            ]);

            return redirect()->back()->with('success', __('app.books.messages.added'));
        } catch (\Exception $e) {
            \Log::error('Error adding book to library: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al añadir el libro a la biblioteca: ' . $e->getMessage());
        }
    }

    public function updateBook(Request $request, $userBookSlug)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string|max:1000',
                'user_rating' => 'nullable|integer|between:1,5',
                'status' => 'nullable|string|in:to-read,reading,read,favorites,wishlist',
                'shelf_ids' => 'nullable|array',
                'shelf_ids.*' => 'exists:user_shelves,id'
            ]);

            $user = Auth::user();
            $userBook = UserBook::where('slug', $userBookSlug)
                               ->where('user_id', $user->id)
                               ->first();

            if (!$userBook) {
                return redirect()->back()->with('error', 'Libro no encontrado en tu biblioteca');
            }

            // Update user book data
            $userBook->update([
                'notes' => $request->notes,
                'user_rating' => $request->user_rating
            ]);

            // Handle shelves (both system status and custom shelves)
            $shelfIds = [];
            
            // Add system shelf if status is provided
            if ($request->has('status') && $request->status) {
                $systemShelf = UserShelf::where('user_id', $user->id)
                                       ->where('slug', $request->status)
                                       ->where('is_system', true)
                                       ->first();
                
                if ($systemShelf) {
                    $shelfIds[] = $systemShelf->id;
                }
            }
            
            // Add custom shelves if provided
            if ($request->has('shelf_ids')) {
                $shelfIds = array_merge($shelfIds, $request->shelf_ids);
            }
            
            // Remove duplicates
            $shelfIds = array_unique($shelfIds);
            
            // Update shelf items
            if (!empty($shelfIds)) {
                // Remove old shelf items
                UserShelfItem::where('user_id', $user->id)
                    ->where('book_id', $userBook->book_id)
                    ->delete();
                
                // Add new shelf items
                foreach ($shelfIds as $shelfId) {
                    UserShelfItem::create([
                        'user_id' => $user->id,
                        'shelf_id' => $shelfId,
                        'book_id' => $userBook->book_id,
                        'position' => 0,
                        'added_at' => now()
                    ]);
                }
            }

            return redirect()->back()->with('success', __('app.books.messages.updated'));
        } catch (\Exception $e) {
            \Log::error('Error updating book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }

    public function deleteBook($userBookSlug)
    {
        try {
            $user = Auth::user();
            $userBook = UserBook::where('slug', $userBookSlug)
                               ->where('user_id', $user->id)
                               ->first();

            if (!$userBook) {
                return redirect()->back()->with('error', __('app.books.messages.not_found'));
            }

            // Delete the user_book (not the book itself)
            $userBook->delete();

            return redirect()->back()->with('success', __('app.books.messages.deleted'));
        } catch (\Exception $e) {
            \Log::error('Error deleting book from library: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el libro: ' . $e->getMessage());
        }
    }

    public function storeCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'color' => 'nullable|string|max:7',
                'icon' => 'nullable|string|max:10'
            ]);

            $user = Auth::user();
            
            // Check if category name already exists for this user
            $exists = UserCategory::where('user_id', $user->id)
                                 ->where('name', $request->name)
                                 ->exists();
            
            if ($exists) {
                return response()->json(['error' => __('app.categories.messages.already_exists')], 422);
            }

            $category = UserCategory::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'color' => $request->color ?? '#3B82F6',
                'icon' => $request->icon
            ]);

            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => __('app.categories.messages.created')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear la categoría'], 500);
        }
    }

    public function updateCategory(Request $request, $categoryId)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:50',
                'color' => 'nullable|string|max:7',
                'icon' => 'nullable|string|max:10'
            ]);

            $user = Auth::user();
            $category = UserCategory::where('id', $categoryId)
                                   ->where('user_id', $user->id)
                                   ->first();

            if (!$category) {
                return response()->json(['error' => __('app.categories.messages.not_found')], 404);
            }

            $category->update([
                'name' => $request->name,
                'color' => $request->color ?? $category->color,
                'icon' => $request->icon
            ]);

            return response()->json([
                'success' => true,
                'category' => $category,
                'message' => __('app.categories.messages.updated')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating category: ' . $e->getMessage());
            return response()->json(['error' => 'Error al actualizar la categoría'], 500);
        }
    }

    public function deleteCategory($categoryId)
    {
        try {
            $user = Auth::user();
            $category = UserCategory::where('id', $categoryId)
                                   ->where('user_id', $user->id)
                                   ->first();

            if (!$category) {
                return response()->json(['error' => __('app.categories.messages.not_found')], 404);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => __('app.categories.messages.deleted')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting category: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar la categoría'], 500);
        }
    }

    public function assignCategories(Request $request, $userBookSlug)
    {
        try {
            $request->validate([
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:user_categories,id'
            ]);

            $user = Auth::user();
            $userBook = UserBook::where('slug', $userBookSlug)
                               ->where('user_id', $user->id)
                               ->first();

            if (!$userBook) {
                return response()->json(['error' => __('app.books.messages.not_found')], 404);
            }

            // Note: This endpoint is deprecated, use updateBook instead

            return response()->json([
                'success' => true,
                'message' => __('app.categories.messages.assigned')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error assigning categories: ' . $e->getMessage());
            return response()->json(['error' => 'Error al asignar categorías'], 500);
        }
    }
}
