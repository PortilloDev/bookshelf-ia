<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnrichImportedBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:enrich-imported {--language=es : Language for book search (es, en, etc.)} {--limit=50 : Maximum number of books to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enrich imported books with data from Google Books and Open Library APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $language = $this->option('language');
        $limit = (int) $this->option('limit');
        
        $this->info("Starting book enrichment process...");
        $this->info("Language: {$language}");
        $this->info("Limit: {$limit} books");
        
        // Get books with source 'import' that need enrichment
        $books = Book::where('source', 'import')
            ->where(function($query) {
                $query->whereNull('description')
                      ->orWhere('description', '')
                      ->orWhereNull('cover_url')
                      ->orWhere('cover_url', '');
            })
            ->limit($limit)
            ->get();
            
        if ($books->isEmpty()) {
            $this->info('No imported books found that need enrichment.');
            return;
        }
        
        $this->info("Found {$books->count()} books to enrich.");
        
        $progressBar = $this->output->createProgressBar($books->count());
        $progressBar->start();
        
        $enriched = 0;
        $errors = 0;
        $failed = 0;
        
        foreach ($books as $book) {
            try {
                $result = $this->enrichBook($book, $language);
                if ($result === 'enriched') {
                    $enriched++;
                } elseif ($result === 'failed') {
                    $failed++;
                }
            } catch (\Exception $e) {
                $errors++;
                Log::error("Error enriching book {$book->id}: " . $e->getMessage());
            }
            
            $progressBar->advance();
            
            // Add small delay to avoid rate limiting
            usleep(500000); // 0.5 seconds
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $this->info("Enrichment completed!");
        $this->info("Books enriched: {$enriched}");
        $this->info("Books marked as failed: {$failed}");
        $this->info("Errors: {$errors}");
    }
    
    private function enrichBook(Book $book, string $language): string
    {
        $this->line("Processing: {$book->title}");
        
        // Try Google Books first (priority)
        $googleData = $this->searchGoogleBooks($book->title, $book->authors[0] ?? '', $language);
        
        if ($googleData) {
            $this->updateBookFromGoogleData($book, $googleData);
            $this->line("  ✓ Found in Google Books - skipping Open Library");
            return 'enriched';
        }
        
        // Only try Open Library if Google Books didn't find anything
        $this->line("  - Google Books: No results found");
        $openLibraryData = $this->searchOpenLibrary($book->title, $book->authors[0] ?? '');
        
        if ($openLibraryData) {
            $this->updateBookFromOpenLibraryData($book, $openLibraryData);
            return 'enriched';
        } else {
            $this->line("  - Open Library: No results found");
            // Mark as failed to avoid retrying in future runs
            $book->update(['source' => 'import_failed']);
            $this->line("  ⚠ Marked as 'import_failed' - will not retry");
            return 'failed';
        }
    }
    
    private function searchGoogleBooks(string $title, string $author, string $language)
    {
        try {
            $query = urlencode("{$title} {$author}");
            $url = "https://www.googleapis.com/books/v1/volumes?q={$query}&langRestrict={$language}&maxResults=1";
            
            $response = Http::timeout(10)->get($url);
            
            if (!$response->successful()) {
                return null;
            }
            
            $data = $response->json();
            
            if (empty($data['items'])) {
                return null;
            }
            
            return $data['items'][0];
        } catch (\Exception $e) {
            Log::warning("Google Books API error: " . $e->getMessage());
            return null;
        }
    }
    
    private function searchOpenLibrary(string $title, string $author)
    {
        try {
            $query = urlencode("{$title} {$author}");
            $url = "https://openlibrary.org/search.json?title={$query}&limit=1";
            
            $response = Http::timeout(10)->get($url);
            
            if (!$response->successful()) {
                return null;
            }
            
            $data = $response->json();
            
            if (empty($data['docs'])) {
                return null;
            }
            
            return $data['docs'][0];
        } catch (\Exception $e) {
            Log::warning("Open Library API error: " . $e->getMessage());
            return null;
        }
    }
    
    private function updateBookFromGoogleData(Book $book, array $data)
    {
        $volumeInfo = $data['volumeInfo'] ?? [];
        
        $updates = [];
        
        // Update description
        if (empty($book->description) && !empty($volumeInfo['description'])) {
            $updates['description'] = $this->cleanDescription($volumeInfo['description']);
        }
        
        // Update authors
        if (empty($book->authors) && !empty($volumeInfo['authors'])) {
            $updates['authors'] = $volumeInfo['authors'];
        }
        
        // Update ISBN and ISBN13
        if (!empty($volumeInfo['industryIdentifiers'])) {
            foreach ($volumeInfo['industryIdentifiers'] as $identifier) {
                if ($identifier['type'] === 'ISBN_13') {
                    if (empty($book->isbn13)) {
                        $updates['isbn13'] = $identifier['identifier'];
                    }
                    if (empty($book->isbn)) {
                        $updates['isbn'] = $identifier['identifier'];
                    }
                } elseif ($identifier['type'] === 'ISBN_10' && empty($book->isbn)) {
                    $updates['isbn'] = $identifier['identifier'];
                }
            }
        }
        
        // Update published date
        if (empty($book->published_date) && !empty($volumeInfo['publishedDate'])) {
            $updates['published_date'] = $volumeInfo['publishedDate'];
        }
        
        // Update page count
        if (empty($book->page_count) && !empty($volumeInfo['pageCount'])) {
            $updates['page_count'] = $volumeInfo['pageCount'];
        }
        
        // Update language
        if (empty($book->language) && !empty($volumeInfo['language'])) {
            $updates['language'] = $volumeInfo['language'];
        }
        
        // Store cover URL directly (don't download)
        if (empty($book->cover_url) && !empty($volumeInfo['imageLinks']['thumbnail'])) {
            $updates['cover_url'] = $volumeInfo['imageLinks']['thumbnail'];
        }
        
        // Update preview URL
        if (empty($book->preview_url) && !empty($volumeInfo['previewLink'])) {
            $updates['preview_url'] = $volumeInfo['previewLink'];
        }
        
        // Update info URL
        if (empty($book->info_url) && !empty($volumeInfo['infoLink'])) {
            $updates['info_url'] = $volumeInfo['infoLink'];
        }
        
        // Update publisher
        if (empty($book->publisher) && !empty($volumeInfo['publisher'])) {
            $updates['publisher'] = $volumeInfo['publisher'];
        }
        
        // Update categories
        if (empty($book->categories) && !empty($volumeInfo['categories'])) {
            $updates['categories'] = $volumeInfo['categories'];
        }
        
        if (!empty($updates)) {
            $book->update($updates);
            $this->line("  ✓ Updated with Google Books data");
        }
    }
    
    private function updateBookFromOpenLibraryData(Book $book, array $data)
    {
        $updates = [];
        
        // Update description
        if (empty($book->description) && !empty($data['first_sentence'])) {
            $updates['description'] = is_array($data['first_sentence']) 
                ? implode(' ', $data['first_sentence']) 
                : $data['first_sentence'];
        }
        
        // Update authors
        if (empty($book->authors) && !empty($data['author_name'])) {
            $updates['authors'] = is_array($data['author_name']) 
                ? $data['author_name'] 
                : [$data['author_name']];
        }
        
        // Update ISBN and ISBN13
        if (!empty($data['isbn'])) {
            $isbn = is_array($data['isbn']) ? $data['isbn'][0] : $data['isbn'];
            
            if (empty($book->isbn)) {
                $updates['isbn'] = $isbn;
            }
            
            // Check if it's ISBN-13 (13 digits)
            if (strlen($isbn) === 13 && empty($book->isbn13)) {
                $updates['isbn13'] = $isbn;
            }
        }
        
        // Update published date
        if (empty($book->published_date) && !empty($data['first_publish_year'])) {
            $updates['published_date'] = $data['first_publish_year'];
        }
        
        // Update language
        if (empty($book->language) && !empty($data['language'])) {
            $updates['language'] = is_array($data['language']) ? $data['language'][0] : $data['language'];
        }
        
        // Store cover URL directly (don't download)
        if (empty($book->cover_url) && !empty($data['cover_i'])) {
            $updates['cover_url'] = "https://covers.openlibrary.org/b/id/{$data['cover_i']}-L.jpg";
        }
        
        // Update publisher
        if (empty($book->publisher) && !empty($data['publisher'])) {
            $publisher = is_array($data['publisher']) ? $data['publisher'][0] : $data['publisher'];
            $updates['publisher'] = $publisher;
        }
        
        // Update categories (subjects)
        if (empty($book->categories) && !empty($data['subject'])) {
            $updates['categories'] = is_array($data['subject']) ? $data['subject'] : [$data['subject']];
        }
        
        // Update page count
        if (empty($book->page_count) && !empty($data['number_of_pages_median'])) {
            $updates['page_count'] = $data['number_of_pages_median'];
        }
        
        if (!empty($updates)) {
            $book->update($updates);
            $this->line("  ✓ Updated with Open Library data");
        }
    }
    
    
    private function cleanDescription(string $description): string
    {
        // Remove HTML tags and clean up
        $description = strip_tags($description);
        $description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');
        $description = trim($description);
        
        // Limit length
        if (strlen($description) > 2000) {
            $description = substr($description, 0, 1997) . '...';
        }
        
        return $description;
    }
}
