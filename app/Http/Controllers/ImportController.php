<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\UserBook;

class ImportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('pages.import', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240' // 10MB max
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            
            // Ensure imports directory exists
            if (!Storage::disk('local')->exists('imports')) {
                Storage::disk('local')->makeDirectory('imports');
            }
            
            // Move file to storage
            $path = $file->store('imports', 'local');
            
            // Get absolute path
            $absolutePath = Storage::disk('local')->path($path);
            
            $imported = 0;
            $errors = [];
            
            if ($extension === 'csv') {
                $imported = $this->importFromCSV($absolutePath, $request);
            } else {
                $imported = $this->importFromExcel($absolutePath, $request);
            }
            
            // Clean up file
            Storage::disk('local')->delete($path);
            
            if ($imported > 0) {
                return redirect()->route('library')->with('success', __('app.import.messages.success') . " ({$imported} libros importados)");
            } else {
                return redirect()->route('import')->with('error', __('app.import.messages.no_books_found'));
            }
            
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->route('import')->with('error', __('app.import.messages.error') . ': ' . $e->getMessage());
        }
    }
    
    private function importFromCSV($absolutePath, $request)
    {
        $user = Auth::user();
        $imported = 0;
        $skipDuplicates = $request->has('skip_duplicates');
        
        if (!file_exists($absolutePath)) {
            throw new \Exception("File not found: {$absolutePath}");
        }
        
        $file = fopen($absolutePath, 'r');
        if ($file === false) {
            throw new \Exception("Could not open file: {$absolutePath}");
        }
        
        $header = fgetcsv($file); // Read header row
        
        if ($header === false || empty($header)) {
            fclose($file);
            throw new \Exception("Could not read header row from CSV file");
        }
        
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 1 || empty($row[0])) continue;
            
            try {
                $data = array_combine($header, $row);
                if ($data !== false) {
                    $imported += $this->importBook($data, $user, $skipDuplicates);
                }
            } catch (\Exception $e) {
                Log::warning('Error importing row: ' . $e->getMessage());
                continue;
            }
        }
        
        fclose($file);
        return $imported;
    }
    
    private function importFromExcel($absolutePath, $request)
    {
        // Basic implementation - you may want to use a library like PhpSpreadsheet
        // For now, we'll try to treat it as CSV (some Excel files can be read this way)
        return $this->importFromCSV($absolutePath, $request);
    }
    
    private function importBook($data, $user, $skipDuplicates)
    {
        $title = $data['title'] ?? $data['Title'] ?? $data['Título'] ?? null;
        if (!$title) return 0;
        
        $authors = $data['author'] ?? $data['Author'] ?? $data['Autor'] ?? null;
        $isbn = $data['isbn'] ?? $data['ISBN'] ?? null;
        $status = $data['status'] ?? $data['Status'] ?? $data['Estado'] ?? 'to-read';
        
        // Check if book already exists for user
        if ($skipDuplicates) {
            $existing = $user->userBooks()->whereHas('book', function($q) use ($title) {
                $q->where('title', $title);
            })->first();
            
            if ($existing) return 0;
        }
        
        // Create or get book
        $book = Book::firstOrCreate(
            ['title' => $title],
            [
                'authors' => $authors ? [$authors] : [],
                'isbn' => $isbn,
                'description' => $data['description'] ?? $data['Description'] ?? $data['Descripción'] ?? null,
                'cover_url' => null,
                'source' => 'import'
            ]
        );
        
        // Add to user library
        UserBook::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => $status,
            'notes' => $data['notes'] ?? $data['Notes'] ?? $data['Notas'] ?? null,
            'rating' => $data['rating'] ?? $data['Rating'] ?? $data['Valoración'] ?? null
        ]);
        
        return 1;
    }
}
