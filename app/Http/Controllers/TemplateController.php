<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function downloadTemplate()
    {
        // Create CSV template content
        $headers = [
            'Título',
            'Autor',
            'Descripción',
            'Categoría',
            'Editorial',
            'Año',
            'Páginas',
            'ISBN',
            'Notas',
            'Reseña',
            'Valoración'
        ];

        $sampleData = [
            [
                'El Quijote',
                'Miguel de Cervantes',
                'Las aventuras de Don Quijote de la Mancha',
                'Clásico',
                'Editorial Castalia',
                '1605',
                '863',
                '978-84-7039-123-4',
                'Libro favorito de la infancia',
                'Una obra maestra de la literatura universal',
                '5'
            ],
            [
                'Cien años de soledad',
                'Gabriel García Márquez',
                'La historia de la familia Buendía',
                'Realismo mágico',
                'Editorial Sudamericana',
                '1967',
                '471',
                '978-84-376-0494-7',
                'Lectura obligatoria en el colegio',
                'Una obra fundamental del boom latinoamericano',
                '5'
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
            'template_file' => 'required|file|mimes:csv,txt,xlsx,xls|max:10240' // 10MB max
        ]);

        $file = $request->file('template_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Store the file temporarily
        $path = $file->storeAs('temp', $filename);
        
        // Process the file (in a real app, you'd parse and import the data)
        $filePath = storage_path('app/' . $path);
        
        // For now, just return success
        return redirect()->back()->with('success', __('app.import.messages.templateUploaded'));
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