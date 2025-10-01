<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::query();

        // Filtros
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->byCategory($request->get('category'));
        }

        if ($request->has('author')) {
            $query->byAuthor($request->get('author'));
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'title');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $books = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $books->items(),
            'pagination' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:20|unique:books',
            'cover_image' => 'nullable|string',
            'publisher' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:10',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'is_available' => 'boolean'
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Libro creado exitosamente',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $id,
            'cover_image' => 'nullable|string',
            'publisher' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:10',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'is_available' => 'boolean'
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Libro actualizado exitosamente',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Libro eliminado exitosamente'
        ]);
    }

    /**
     * Get books by category
     */
    public function byCategory(string $category): JsonResponse
    {
        $books = Book::byCategory($category)->get();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    /**
     * Search books
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Query parameter is required'
            ], 400);
        }

        $books = Book::where('title', 'like', "%{$query}%")
                    ->orWhere('author', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }
}
