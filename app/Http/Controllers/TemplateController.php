<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function downloadTemplate()
    {
        // Create CSV template content - headers must match ImportController expectations
        $headers = [
            'title',
            'author',
            'isbn',
            'status',
            'description',
            'notes',
            'rating'
        ];

        $sampleData = [
            [
                'El Quijote',
                'Miguel de Cervantes',
                '978-84-7039-123-4',
                'completed',
                'Las aventuras de Don Quijote de la Mancha, una obra maestra de la literatura universal',
                'Libro favorito de la infancia',
                '5'
            ],
            [
                'Cien años de soledad',
                'Gabriel García Márquez',
                '978-84-376-0494-7',
                'to-read',
                'La historia de la familia Buendía a lo largo de siete generaciones',
                'Lectura obligatoria en el colegio',
                ''
            ],
            [
                '1984',
                'George Orwell',
                '978-84-376-0494-9',
                'reading',
                'Novela distópica sobre un régimen totalitario',
                'Muy interesante y actual',
                '4'
            ]
        ];

        $csvContent = $this->arrayToCsv([$headers] + $sampleData);

        return response($csvContent)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="plantilla_libros.csv"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'template_file' => 'required|file|mimes:csv,xlsx,xls|max:2048' // 2MB max (matching PHP config)
        ]);

        $file = $request->file('template_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Store the file temporarily
        $path = $file->storeAs('temp', $filename);
        
        // Redirect to import page with the file path for processing
        return redirect()->route('import')->with('success', 'Archivo cargado correctamente. Ahora puedes procesarlo usando el formulario de importación.');
    }

    private function arrayToCsv(array $data)
    {
        $output = fopen('php://temp', 'r+');
        
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }
}