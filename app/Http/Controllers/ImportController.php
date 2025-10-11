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
        // Debug logging
        Log::info('Import request received', [
            'method' => $request->method(),
            'has_file' => $request->hasFile('file'),
            'all_files' => $request->allFiles(),
            'all_data' => $request->all()
        ]);

        // Additional file debugging
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Log::info('File details', [
                'original_name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'is_valid' => $file->isValid(),
                'error' => $file->getError()
            ]);
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:2048', // 2MB max (matching PHP config)
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $allowedExtensions = ['csv', 'xlsx', 'xls'];
                    
                    if (!in_array($extension, $allowedExtensions)) {
                        $fail('El archivo debe ser un CSV o Excel (.csv, .xlsx, .xls). Extensión recibida: ' . $extension);
                    }
                }
            ]
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
                return redirect()->route('library')->with('success', "¡Importación exitosa! Se importaron {$imported} libros.");
            } else {
                return redirect()->route('import')->with('error', 'No se encontraron libros válidos para importar. Verifica que el archivo tenga el formato correcto y que las columnas requeridas estén presentes.');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Import validation error: ' . $e->getMessage());
            return redirect()->route('import')->withErrors($e->errors())->withInput();
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
        
        // Read first line to detect separator
        $firstLine = fgets($file);
        rewind($file);
        
        // Detect separator (comma or semicolon)
        $separator = ',';
        if (strpos($firstLine, ';') !== false && strpos($firstLine, ';') > strpos($firstLine, ',')) {
            $separator = ';';
        }
        
        Log::info('CSV separator detected', ['separator' => $separator, 'first_line' => $firstLine]);
        
        $header = fgetcsv($file, 0, $separator); // Read header row with detected separator
        
        if ($header === false || empty($header)) {
            fclose($file);
            throw new \Exception("Could not read header row from CSV file");
        }
        
        Log::info('CSV header parsed', ['header' => $header, 'header_count' => count($header)]);
        
        $rowNumber = 1; // Start from 1 since we already read the header
        
        while (($row = fgetcsv($file, 0, $separator)) !== false) {
            $rowNumber++;
            
            if (count($row) < 1 || empty($row[0])) {
                Log::warning("Skipping empty row at line {$rowNumber}");
                continue;
            }
            
            // Check if row has same number of columns as header
            if (count($row) !== count($header)) {
                Log::warning("Row {$rowNumber} has " . count($row) . " columns but header has " . count($header) . " columns. Skipping row.");
                continue;
            }
            
            try {
                $data = array_combine($header, $row);
                if ($data !== false) {
                    $imported += $this->importBook($data, $user, $skipDuplicates);
                } else {
                    Log::warning("Failed to combine header and row data at line {$rowNumber}");
                }
            } catch (\Exception $e) {
                Log::warning("Error importing row {$rowNumber}: " . $e->getMessage());
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
        // Log the data being processed for debugging
        Log::info('Processing book data', ['data' => $data]);
        
        // Try different variations of title field names
        $title = $data['title'] ?? $data['Title'] ?? $data['Título'] ?? $data['titulo'] ?? null;
        
        // If still no title, try to get the first non-empty value as title
        if (!$title) {
            foreach ($data as $key => $value) {
                if (!empty(trim($value))) {
                    $title = trim($value);
                    Log::info("Using first non-empty field as title", ['field' => $key, 'value' => $title]);
                    break;
                }
            }
        }
        
        if (!$title) {
            Log::warning('Book skipped: No title found', ['available_keys' => array_keys($data), 'data' => $data]);
            return 0;
        }
        
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
