<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BookSearchService
{
    private $googleBooksApiKey;
    private $openLibraryBaseUrl = 'https://openlibrary.org';

    public function __construct()
    {
        $this->googleBooksApiKey = config('services.google_books.api_key');
    }

    /**
     * Search books from multiple sources
     */
    public function searchBooks($query, $options = [])
    {
        $results = [];
        $localBookIds = [];
        
        // First, search in local database if user is authenticated
        if (!empty($options['user_id'])) {
            $localResults = $this->searchLocalBooks($query, $options);
            if (!empty($localResults)) {
                $results = array_merge($results, $localResults);
                
                // Store local book IDs to filter duplicates from external APIs
                foreach ($localResults as $book) {
                    if (!empty($book['id'])) {
                        $localBookIds[] = $book['id'];
                    }
                }
            }
        }
        
        // Then search external APIs
        // Try Google Books first
        $googleResults = $this->searchGoogleBooks($query, $options);
        if (!empty($googleResults)) {
            // Filter out books that are already in local results
            $googleResults = $this->filterDuplicates($googleResults, $localBookIds);
            $results = array_merge($results, $googleResults);
        }
        
        // If still no results or need more, try Open Library
        if (count($results) < ($options['limit'] ?? 20)) {
            $openLibraryResults = $this->searchOpenLibrary($query, $options);
            // Filter out books that are already in results
            $openLibraryResults = $this->filterDuplicates($openLibraryResults, $localBookIds);
            $results = array_merge($results, $openLibraryResults);
        }
        
        return $results;
    }
    
    /**
     * Filter out duplicate books based on IDs
     */
    private function filterDuplicates($books, $existingIds)
    {
        if (empty($existingIds)) {
            return $books;
        }
        
        return array_filter($books, function($book) use ($existingIds) {
            return !in_array($book['id'] ?? null, $existingIds);
        });
    }
    
    /**
     * Search books in local database
     */
    private function searchLocalBooks($query, $options = [])
    {
        try {
            $user = \App\Models\User::find($options['user_id']);
            if (!$user) {
                return [];
            }
            
            // Search in user's books
            $userBooks = $user->userBooks()
                ->with('book')
                ->whereHas('book', function($q) use ($query) {
                    $q->where('title', 'ilike', "%{$query}%")
                      ->orWhereRaw("authors::text ilike ?", ["%{$query}%"]);
                })
                ->limit(5) // Limit local results
                ->get();
            
            $results = [];
            foreach ($userBooks as $userBook) {
                $book = $userBook->book;
                $results[] = [
                    'id' => $book->external_id ?? $book->id,
                    'source' => $book->source ?? 'local',
                    'title' => $book->title,
                    'authors' => $book->authors ?? [],
                    'description' => $book->description,
                    'cover_url' => $book->cover_url,
                    'publisher' => $book->publisher,
                    'published_date' => $book->published_date,
                    'page_count' => $book->page_count,
                    'isbn' => $book->isbn,
                    'rating' => $book->rating,
                    'categories' => $book->categories ?? [],
                    'preview_url' => $book->preview_url,
                    'info_url' => $book->info_url,
                    'in_library' => true, // Mark as already in library
                    'user_status' => $userBook->status,
                ];
            }
            
            return $results;
        } catch (\Exception $e) {
            \Log::error('Local search error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Google Books API
     */
    private function searchGoogleBooks($query, $options = [])
    {
        try {
            // Build search query based on type
            $searchQuery = $query;
            $type = $options['type'] ?? 'general';
            
            if ($type === 'title') {
                $searchQuery = 'intitle:' . $query;
            } elseif ($type === 'author') {
                $searchQuery = 'inauthor:' . $query;
            } elseif ($type === 'isbn') {
                $searchQuery = 'isbn:' . $query;
            } elseif ($type === 'subject') {
                $searchQuery = 'subject:' . $query;
            }
            
            $params = [
                'q' => $searchQuery,
                'maxResults' => $options['limit'] ?? 20,
                'startIndex' => $options['offset'] ?? 0,
                'printType' => 'books'
            ];
            
            // Only apply language filter if specified and not 'all'
            $language = $options['language'] ?? 'es';
            if ($language !== 'all') {
                $params['langRestrict'] = $language;
            }
            
            // Apply sorting if specified
            $sort = $options['sort'] ?? 'relevance';
            if ($sort === 'newest') {
                $params['orderBy'] = 'newest';
            }

            if ($this->googleBooksApiKey) {
                $params['key'] = $this->googleBooksApiKey;
            }

            $response = Http::timeout(10)->get('https://www.googleapis.com/books/v1/volumes', $params);
            
            if ($response->successful()) {
                $data = $response->json();
                return $this->formatGoogleBooksResults($data);
            }
        } catch (\Exception $e) {
            \Log::error('Google Books API error: ' . $e->getMessage());
        }
        
        return [];
    }

    /**
     * Search Open Library API
     */
    private function searchOpenLibrary($query, $options = [])
    {
        try {
            $params = [
                'q' => $query,
                'limit' => $options['limit'] ?? 20,
                'offset' => $options['offset'] ?? 0,
                'fields' => 'key,title,author_name,first_publish_year,cover_i,isbn,subject,language'
            ];

            $response = Http::timeout(10)->get($this->openLibraryBaseUrl . '/search.json', $params);
            
            if ($response->successful()) {
                $data = $response->json();
                return $this->formatOpenLibraryResults($data);
            }
        } catch (\Exception $e) {
            \Log::error('Open Library API error: ' . $e->getMessage());
        }
        
        return [];
    }

    /**
     * Format Google Books results
     */
    private function formatGoogleBooksResults($data)
    {
        $books = [];
        
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $volumeInfo = $item['volumeInfo'] ?? [];
                
                $books[] = [
                    'id' => $item['id'] ?? null,
                    'source' => 'google_books',
                    'title' => $volumeInfo['title'] ?? 'Sin título',
                    'authors' => $volumeInfo['authors'] ?? [],
                    'description' => $volumeInfo['description'] ?? '',
                    'published_date' => $volumeInfo['publishedDate'] ?? null,
                    'page_count' => $volumeInfo['pageCount'] ?? null,
                    'language' => $volumeInfo['language'] ?? 'es',
                    'isbn' => $this->extractIsbn($volumeInfo['industryIdentifiers'] ?? []),
                    'categories' => $volumeInfo['categories'] ?? [],
                    'rating' => $volumeInfo['averageRating'] ?? null,
                    'reviews_count' => $volumeInfo['ratingsCount'] ?? 0,
                    'cover_url' => $this->getGoogleBooksCoverUrl($item['id'] ?? null),
                    'preview_url' => $volumeInfo['previewLink'] ?? null,
                    'info_url' => $volumeInfo['infoLink'] ?? null
                ];
            }
        }
        
        return $books;
    }

    /**
     * Format Open Library results
     */
    private function formatOpenLibraryResults($data)
    {
        $books = [];
        
        if (isset($data['docs'])) {
            foreach ($data['docs'] as $doc) {
                $books[] = [
                    'id' => $doc['key'] ?? null,
                    'source' => 'open_library',
                    'title' => $doc['title'] ?? 'Sin título',
                    'authors' => $doc['author_name'] ?? [],
                    'description' => '', // Open Library doesn't provide descriptions in search
                    'published_date' => $doc['first_publish_year'] ?? null,
                    'page_count' => null,
                    'language' => $doc['language'] ?? 'es',
                    'isbn' => $doc['isbn'] ?? [],
                    'categories' => $doc['subject'] ?? [],
                    'rating' => null,
                    'reviews_count' => 0,
                    'cover_url' => $this->getOpenLibraryCoverUrl($doc['cover_i'] ?? null),
                    'preview_url' => null,
                    'info_url' => $this->openLibraryBaseUrl . ($doc['key'] ?? '')
                ];
            }
        }
        
        return $books;
    }

    /**
     * Extract ISBN from industry identifiers
     */
    private function extractIsbn($identifiers)
    {
        foreach ($identifiers as $identifier) {
            if ($identifier['type'] === 'ISBN_13' || $identifier['type'] === 'ISBN_10') {
                return $identifier['identifier'];
            }
        }
        return null;
    }

    /**
     * Get Google Books cover URL
     */
    private function getGoogleBooksCoverUrl($bookId)
    {
        if ($bookId) {
            return "https://books.google.com/books/content?id={$bookId}&printsec=frontcover&img=1&zoom=1";
        }
        return null;
    }

    /**
     * Get Open Library cover URL
     */
    private function getOpenLibraryCoverUrl($coverId)
    {
        if ($coverId) {
            return "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg";
        }
        return null;
    }

    /**
     * Get book details by ID and source
     */
    public function getBookDetails($bookId, $source)
    {
        if ($source === 'google_books') {
            return $this->getGoogleBooksDetails($bookId);
        } elseif ($source === 'open_library') {
            return $this->getOpenLibraryDetails($bookId);
        }
        
        return null;
    }

    /**
     * Get Google Books book details
     */
    private function getGoogleBooksDetails($bookId)
    {
        try {
            $params = ['key' => $this->googleBooksApiKey];
            $response = Http::timeout(10)->get("https://www.googleapis.com/books/v1/volumes/{$bookId}", $params);
            
            if ($response->successful()) {
                $data = $response->json();
                return $this->formatGoogleBooksResults(['items' => [$data]])[0] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error('Google Books details error: ' . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Get Open Library book details
     */
    private function getOpenLibraryDetails($bookId)
    {
        try {
            $response = Http::timeout(10)->get("{$this->openLibraryBaseUrl}{$bookId}.json");
            
            if ($response->successful()) {
                $data = $response->json();
                return $this->formatOpenLibraryBookDetails($data);
            }
        } catch (\Exception $e) {
            \Log::error('Open Library details error: ' . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Format Open Library book details
     */
    private function formatOpenLibraryBookDetails($data)
    {
        return [
            'id' => $data['key'] ?? null,
            'source' => 'open_library',
            'title' => $data['title'] ?? 'Sin título',
            'authors' => $data['authors'] ?? [],
            'description' => $data['description'] ?? '',
            'published_date' => $data['first_publish_date'] ?? null,
            'page_count' => $data['number_of_pages'] ?? null,
            'language' => $data['languages'] ?? ['es'],
            'isbn' => $data['isbn_13'] ?? $data['isbn_10'] ?? null,
            'categories' => $data['subjects'] ?? [],
            'rating' => null,
            'reviews_count' => 0,
            'cover_url' => $this->getOpenLibraryCoverUrl($data['covers'][0] ?? null),
            'preview_url' => null,
            'info_url' => $this->openLibraryBaseUrl . ($data['key'] ?? '')
        ];
    }
}
