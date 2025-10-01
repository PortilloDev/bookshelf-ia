<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('title');
            $t->string('subtitle')->nullable();
            $t->json('authors')->nullable();         // array de autores
            $t->text('description')->nullable();
            $t->json('tags')->nullable();            // array de tags
            $t->string('language', 5)->default('es');
            $t->string('isbn13', 13)->nullable()->index();
            $t->string('cover_url')->nullable();
            $t->timestamp('published_at')->nullable();

            // Metadatos de embeddings
            $t->string('embedding_model')->nullable();
            $t->unsignedSmallInteger('embedding_dim')->nullable();
            $t->timestamp('embedding_updated_at')->nullable();

            $t->timestamps();
        });

        // Full-text search en español (tsvector generado)
        DB::statement("
                    ALTER TABLE books
                    ADD COLUMN tsv tsvector
                    GENERATED ALWAYS AS (
                        setweight(to_tsvector('spanish', coalesce(title,'')), 'A') ||
                        setweight(to_tsvector('spanish', coalesce(subtitle,'')), 'B') ||
                        -- aquí el fix: JSON -> text (no text[])
                        setweight(to_tsvector('spanish', coalesce(authors::text,'')), 'C') ||
                        setweight(to_tsvector('spanish', coalesce(description,'')), 'D')
                    ) STORED
                ");
        DB::statement("CREATE INDEX idx_books_tsv ON books USING GIN(tsv)");

        // Columna vector y índice ANN (ajusta dimensión si usas otro modelo)
        DB::statement("ALTER TABLE books ADD COLUMN embedding vector(1536)");
        DB::statement("
            CREATE INDEX books_embedding_ivf
            ON books USING ivfflat (embedding vector_cosine_ops)
            WITH (lists = 100)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
