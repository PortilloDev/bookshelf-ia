<?php

namespace App\Console\Commands;

use App\Jobs\GenerateBookEmbedding;
use App\Models\Book;
use Illuminate\Console\Command;

class BooksEmbed extends Command
{
    protected $signature = 'books:embed
                            {--only-missing : Solo libros sin embedding}
                            {--limit=0 : Limitar número de libros}
                            {--queue : Encolar en vez de ejecutar ahora}';

    protected $description = 'Genera y guarda embeddings para libros';

    public function handle(): int
    {
        $query = Book::query();

        if ($this->option('only-missing')) {
            $query->whereNull('embedding');
        }

        $limit = (int) $this->option('limit');
        if ($limit > 0) {
            $query->limit($limit);
        }

        $count = 0;
        $query->orderBy('created_at')->chunk(100, function ($books) use (&$count) {
            foreach ($books as $book) {
                $count++;
                if ($this->option('queue')) {
                    dispatch(new GenerateBookEmbedding($book->id))->onQueue('default');
                } else {
                    // Ejecuta el Job en el proceso actual
                    (new GenerateBookEmbedding($book->id))->handle(app(\App\Services\EmbeddingService::class));
                }
                $this->components->info("Procesado: {$book->title}");
            }
        });

        $this->components->success("Total procesados: {$count}");
        if ($this->option('queue')) {
            $this->line('Recuerda arrancar el worker: php artisan queue:work');
        }
        return self::SUCCESS;
    }
}
