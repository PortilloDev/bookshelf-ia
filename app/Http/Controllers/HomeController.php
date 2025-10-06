<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\BookSearchService;

class HomeController extends Controller
{
    protected $bookSearchService;

    public function __construct(BookSearchService $bookSearchService)
    {
        $this->bookSearchService = $bookSearchService;
    }

    public function index()
    {
        // Cache popular books for 60 minutes
        $popularBooks = Cache::remember('popular_books', 60 * 60, function () {
            try {
                // Search for popular/bestseller books
                $books = $this->bookSearchService->searchBooks('bestseller', [
                    'limit' => 8,
                    'language' => app()->getLocale()
                ]);
                
                return $books;
            } catch (\Exception $e) {
                \Log::error('Error fetching popular books: ' . $e->getMessage());
                return [];
            }
        });

        return view('pages.home', compact('popularBooks'));
    }
}
