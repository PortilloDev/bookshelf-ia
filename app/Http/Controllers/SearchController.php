<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookSearchService;

class SearchController extends Controller
{
    protected $bookSearchService;

    public function __construct(BookSearchService $bookSearchService)
    {
        $this->bookSearchService = $bookSearchService;
    }

    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $books = [];
        $totalResults = 0;
        $isLoading = false;
        $userBookIds = [];

        // If there's a search query, perform the search
        if (!empty($query)) {
            $isLoading = true;
            
            $searchOptions = [
                'limit' => $request->get('limit', 20),
                'offset' => $request->get('offset', 0),
                'language' => $request->get('language', 'all'),
                'type' => $request->get('type', 'general'),
                'sort' => $request->get('sort', 'relevance'),
                'user_id' => auth()->id() // Pass user ID for local search
            ];

            try {
                $books = $this->bookSearchService->searchBooks($query, $searchOptions);
                $totalResults = count($books);
                
                // Get user's book IDs to mark which books are already in library
                if (auth()->check()) {
                    $userBookIds = auth()->user()->userBooks()
                        ->with('book')
                        ->get()
                        ->pluck('book.external_id', 'book.source')
                        ->all();
                }
            } catch (\Exception $e) {
                \Log::error('Search error: ' . $e->getMessage());
                $books = [];
                $totalResults = 0;
            }
            
            $isLoading = false;
        }

        return view('pages.search', compact('query', 'books', 'totalResults', 'isLoading', 'userBookIds'));
    }

    public function show($source, $id)
    {
        try {
            $book = $this->bookSearchService->getBookDetails($id, $source);
            
            if (!$book) {
                abort(404, 'Libro no encontrado');
            }
            
            return view('pages.book-details', compact('book', 'source', 'id'));
        } catch (\Exception $e) {
            \Log::error('Book details error: ' . $e->getMessage());
            abort(404, 'Error al cargar los detalles del libro');
        }
    }
}
