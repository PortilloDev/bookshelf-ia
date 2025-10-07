<?php

namespace App\Services\Ingest;

use App\Models\Book;
use App\Models\BookRaw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookNormalizer
{
    public function normalizePending(int $limit = 20000): int
    {
        $rows = BookRaw::query()
            ->whereIn('status', ['fetched','changed'])
            ->orderBy('updated_at')
            ->limit($limit)
            ->get();

        $created = 0; $updated = 0; $skipped = 0; $failed = 0;

        foreach ($rows as $raw) {
            $result = $this->normalizeOne($raw);

            // marca el estado según resultado
            $raw->status = match ($result) {
                'created', 'updated' => 'unchanged',
                'skipped'            => 'unchanged',
                'failed'             => 'error',
                default              => 'error',
            };
            $raw->save();

            // contadores
            match ($result) {
                'created' => $created++,
                'updated' => $updated++,
                'skipped' => $skipped++,
                'failed'  => $failed++,
                default   => $failed++,
            };
        }

        // imprime resumen claro en logs (y tu comando mostrará el total que devuelvo)
        Log::info('[books:normalize] resumen', compact('created','updated','skipped','failed'));

        // devuelve SOLO éxitos (útil para ver si realmente insertó/actualizó)
        return $created + $updated;
    }

    private function normalizeOne(BookRaw $raw): string
    {
        $p = $raw->payload_json;

        $title = trim((string)($p['title'] ?? ''));
        if ($title === '') {
            \Log::warning('[normalize] skip por título vacío', ['raw_id'=>$raw->id, 'source'=>$raw->source, 'external_id'=>$raw->external_id]);
            return 'skipped';
        }

        $authorsArr = array_values(array_filter(array_map('strval', $p['authors'] ?? [])));
        $desc       = $this->clean((string)($p['description'] ?? ''));
        $lang       = $this->normLang((string)($p['language'] ?? 'es'));
        $isbn13     = $this->normIsbn13($p['isbn13'] ?? null);
        $cover      = $p['cover_url'] ?? null;
        $tagsArr    = $p['categories'] ?? [];

        // 👇 IMPORTANTE: serializamos a JSON para columnas jsonb
        $authorsJson = json_encode($authorsArr,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        $tagsJson    = json_encode($tagsArr,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        // DEDUPE
        $book = null;
        if ($isbn13) {
            $book = Book::query()->where('isbn13', $isbn13)->first();
        }
        if (!$book) {
            $book = Book::query()
                ->whereRaw('lower(title) = ?', [mb_strtolower($title,'UTF-8')])
                ->when(count($authorsArr) > 0, function ($q) use ($authorsArr) {
                    $q->whereRaw('authors::jsonb @> ?::jsonb', [json_encode([$authorsArr[0]])]);
                })
                ->first();
        }

        // Datos listos para SQL (authors/tags ya son JSON string)
        $data = [
            'title'       => $title,
            'subtitle'    => null,
            'authors'     => $authorsJson,   // 👈 JSON string
            'description' => $desc,
            'tags'        => $tagsJson,      // 👈 JSON string
            'language'    => $lang,
            'isbn13'      => $isbn13,
            'cover_url'   => $cover,
        ];

        DB::beginTransaction();
        try {
            if ($book) {
                DB::table('books')->where('id', $book->id)->update($data + ['updated_at' => now()]);
                $bookId = $book->id;
                $result = 'updated';
            } else {
                $bookId = (string) \Str::uuid();
                DB::table('books')->insert($data + [
                        'id'         => $bookId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                $result = 'created';
            }

            // Pivot categorías (si existen)
            if (\Schema::hasTable('categories') && !empty($tagsArr)) {
                $catIds = \DB::table('categories')->whereIn('slug', $tagsArr)->pluck('id')->all();
                if ($catIds) {
                    \DB::table('book_category')->where('book_id', $bookId)->delete();
                    $rows = array_map(fn($cid) => ['book_id'=>$bookId,'category_id'=>$cid], $catIds);
                    \DB::table('book_category')->insert($rows);
                }
            }

            // external_refs
            $keys   = ['book_id' => $bookId, 'source' => $raw->source, 'external_id' => $raw->external_id];
            $values = ['url' => null, 'updated_at' => now()];

            // 1) Intento de UPDATE
            $updated = \DB::table('external_refs')->where($keys)->update($values);

            // 2) Si no existía, INSERT con id nuevo
            if ($updated === 0) {
                \DB::table('external_refs')->insert($keys + [
                        'id'         => (string) \Illuminate\Support\Str::uuid(),
                        'url'        => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }

            DB::commit();
            return $result;

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('[normalize] fallo', [
                'raw_id'=>$raw->id, 'source'=>$raw->source, 'external_id'=>$raw->external_id, 'error'=>$e->getMessage()
            ]);
            return 'failed';
        }
    }

    private function clean(string $t): string
    {
        $t = strip_tags($t);
        $t = preg_replace('/\s+/u', ' ', $t);
        return trim($t);
    }

    private function normLang(?string $l): string
    {
        $l = strtolower((string)$l);
        return in_array($l, ['es','spa','es-es','español']) ? 'es' : substr($l,0,2);
    }

    private function normIsbn13(?string $i): ?string
    {
        if (!$i) return null;
        $d = preg_replace('/[^0-9X]/i', '', $i);
        return strlen($d) === 13 ? $d : null;
    }
}
