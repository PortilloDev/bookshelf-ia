<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Quitar índice e columna generada que dependen de authors
        DB::statement('DROP INDEX IF EXISTS idx_books_tsv');
        DB::statement('ALTER TABLE books DROP COLUMN IF EXISTS tsv');

        // 2) Convertir a JSONB (ya no hay dependencia)
        DB::statement("ALTER TABLE books ALTER COLUMN authors TYPE jsonb USING authors::jsonb");
        DB::statement("ALTER TABLE books ALTER COLUMN tags    TYPE jsonb USING tags::jsonb");

        // 3) Recrear la columna generada tsv y su índice
        DB::statement("
            ALTER TABLE books
            ADD COLUMN tsv tsvector
            GENERATED ALWAYS AS (
                setweight(to_tsvector('spanish', coalesce(title,'')), 'A') ||
                setweight(to_tsvector('spanish', coalesce(subtitle,'')), 'B') ||
                setweight(to_tsvector('spanish', coalesce(authors::text,'')), 'C') ||
                setweight(to_tsvector('spanish', coalesce(description,'')), 'D')
            ) STORED
        ");

        DB::statement("CREATE INDEX idx_books_tsv ON books USING GIN (tsv)");
    }

    public function down(): void
    {
        // Inverso razonable: volver a json (no suele hacer falta) y recrear tsv igual
        DB::statement('DROP INDEX IF EXISTS idx_books_tsv');
        DB::statement('ALTER TABLE books DROP COLUMN IF EXISTS tsv');

        DB::statement("ALTER TABLE books ALTER COLUMN authors TYPE json USING authors::json");
        DB::statement("ALTER TABLE books ALTER COLUMN tags    TYPE json USING tags::json");

        DB::statement("
            ALTER TABLE books
            ADD COLUMN tsv tsvector
            GENERATED ALWAYS AS (
                setweight(to_tsvector('spanish', coalesce(title,'')), 'A') ||
                setweight(to_tsvector('spanish', coalesce(subtitle,'')), 'B') ||
                setweight(to_tsvector('spanish', coalesce(authors::text,'')), 'C') ||
                setweight(to_tsvector('spanish', coalesce(description,'')), 'D')
            ) STORED
        ");

        DB::statement('CREATE INDEX idx_books_tsv ON books USING GIN (tsv)');
    }
};
