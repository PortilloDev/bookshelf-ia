<?php

return [
    'title' => 'Importar Libros',
    'subtitle' => 'Sube tu lista de libros desde un archivo Excel o CSV',
    'instructions' => [
        'format' => [
            'title' => 'Formatos Soportados',
            'csv' => 'Archivos CSV (.csv)',
            'excel' => 'Archivos Excel (.xlsx, .xls)',
            'size' => 'Tamaño máximo: 10MB'
        ],
        'columns' => [
            'title' => 'Columnas Requeridas',
            'required' => 'Título (obligatorio)',
            'optional' => 'Autor, ISBN (opcional)',
            'metadata' => 'Fecha de publicación, páginas',
            'personal' => 'Notas, categoría, rating personal'
        ],
        'note' => '¿No tienes un archivo? Descarga nuestra plantilla de ejemplo o sube tu archivo existente.'
    ],
    'upload' => [
        'title' => 'Selecciona tu archivo',
        'description' => 'Arrastra y suelta tu archivo aquí o haz clic para seleccionar',
        'supports' => 'Soporta archivos CSV, XLSX y XLS hasta 10MB',
        'process_file' => 'Procesar Archivo'
    ],
    'options' => [
        'title' => 'Opciones de Importación',
        'create_categories' => 'Crear categorías automáticamente',
        'skip_duplicates' => 'Omitir libros duplicados',
        'validate_isbn' => 'Validar códigos ISBN'
    ],
    'messages' => [
        'success' => 'Archivo importado exitosamente',
        'error' => 'Error al procesar el archivo',
        'invalid_format' => 'Formato de archivo no válido',
        'file_too_large' => 'El archivo es demasiado grande',
        'no_books_found' => 'No se encontraron libros en el archivo'
    ]
];
