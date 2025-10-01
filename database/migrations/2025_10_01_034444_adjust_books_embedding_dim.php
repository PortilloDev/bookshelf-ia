<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Cambia la columna a vector(768) para que coincida con Gemini text-embedding-004
        DB::statement('ALTER TABLE books ALTER COLUMN embedding TYPE vector(768)');
    }

    public function down(): void
    {
        // Si antes la tenías en 1536, vuelve a ese tamaño; ajusta si era otro
        DB::statement('ALTER TABLE books ALTER COLUMN embedding TYPE vector(1536)');
    }
};
