<?php

namespace App\Jobs;

use App\Models\Book;
use App\Services\EmbeddingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\DB;

class GenerateBookEmbedding implements ShouldQueue
{
    use Queueable;

    /** Reintentos y backoff progresivo (10s, 30s, 2m, 5m). */
    public int $tries = 5;
    public function backoff(): array { return [10, 30, 120, 300]; }

    public function __construct(public string $bookId) {}

    /** Evita solapamientos por bookId (requiere cache/redis). */
    public function middleware(): array
    {
        return [
            new WithoutOverlapping($this->bookId),
            new RateLimited('embeddings'), // definido en AppServiceProvider
        ];
    }

    public function handle(EmbeddingService $emb): void
    {
        /** @var Book|null $book */
        $book = Book::query()->find($this->bookId);
        if (!$book) return;

        // 1) texto canónico
        $parts = [
            $book->title,
            $book->subtitle,
            is_array($book->authors) ? implode(', ', $book->authors) : (string) $book->authors,
            is_array($book->tags)    ? implode(', ', $book->tags)    : (string) $book->tags,
            $book->description,
        ];
        $payload = trim(preg_replace('/\s+/u', ' ', implode("\n", array_filter($parts))));

        // 2) checksum: contenido + modelo + proveedor + taskType
        $provider = config('services.embeddings.provider', 'google');
        $model    = config('services.embeddings.model');
        $newHash  = hash('sha256', $payload.'|'.$model.'|DOC|'.$provider);

        // 3) si nada cambió, salimos (sin llamar a la API)
        if ($book->embedding_hash === $newHash && $book->embedding_dim) {
            return;
        }

        // 4) generar embedding (document)
        $vec = $emb->embedDocument($payload);
        $literal = '['.implode(',', $vec).']';

        // 5) guardar
        DB::update("
            UPDATE books
            SET embedding = ?,
                embedding_model = ?,
                embedding_dim = ?,
                embedding_provider = ?,
                embedding_hash = ?,
                embedding_updated_at = NOW()
            WHERE id = ?
        ", [
            $literal, $model, count($vec), $provider, $newHash, $book->id,
        ]);
    }
}
