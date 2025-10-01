<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\UserBook;

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
        $category = $request->get('category', 'all');
        
        // Get user books from database
        $query = $user->userBooks()->with('book');
        
        // Filter by search query
        if (!empty($searchQuery)) {
            $query->whereHas('book', function($q) use ($searchQuery) {
                $q->where('title', 'ilike', "%{$searchQuery}%")
                  ->orWhereJsonContains('authors', $searchQuery);
            });
        }
        
        // Filter by category
        if ($category !== 'all') {
            $query->where('status', $category);
        }
        
        $userBooks = $query->get();
        
        $categories = [
            ['id' => 'to-read', 'name' => 'Por Leer', 'icon' => '📚'],
            ['id' => 'reading', 'name' => 'Leyendo', 'icon' => '📖'],
            ['id' => 'read', 'name' => 'Leídos', 'icon' => '✅'],
            ['id' => 'favorites', 'name' => 'Favoritos', 'icon' => '❤️'],
            ['id' => 'wishlist', 'name' => 'Lista de Deseos', 'icon' => '⭐']
        ];

        return view('pages.library', compact('user', 'userBooks', 'categories', 'searchQuery', 'category'));
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

    public function updateBook(Request $request, $userBookId)
    {
        try {
            $request->validate([
                'notes' => 'nullable|string|max:1000',
                'status' => 'nullable|string|in:to-read,reading,read,favorites,wishlist',
                'user_rating' => 'nullable|integer|between:1,5'
            ]);

            $user = Auth::user();
            $userBook = UserBook::where('id', $userBookId)
                               ->where('user_id', $user->id)
                               ->first();

            if (!$userBook) {
                return redirect()->back()->with('error', 'Libro no encontrado en tu biblioteca');
            }

            $userBook->update([
                'notes' => $request->notes,
                'status' => $request->status ?? $userBook->status,
                'user_rating' => $request->user_rating
            ]);

            return redirect()->back()->with('success', __('app.books.messages.updated'));
        } catch (\Exception $e) {
            \Log::error('Error updating book: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el libro: ' . $e->getMessage());
        }
    }
}
