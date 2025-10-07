<?php

namespace App\Services\Ingest;

use App\Models\Dto\RawBookDTO;
use Illuminate\Support\Facades\Http;

class GoogleBooksAdapter implements BookSourceAdapterInterface
{
    private const GOOGLE_NAME = 'google_books';
    /**
     * @inheritDoc
     */

    public function getSourceName(): string
    {
        return self::GOOGLE_NAME;
    }

    /**
     * @inheritDoc
     */
    public function fetchByCategory(string $categorySlug, int $page=1, int $perPage=40): array
    {
        $q = $this->mapCategoryToQuery($categorySlug);
        $startIndex = ($page-1) * $perPage;

        $resp = Http::retry(3, 500)->get('https://www.googleapis.com/books/v1/volumes', [
            'q'           => "subject:{$q}",
            'langRestrict'=> 'es',
            'printType'   => 'books',
            'orderBy'     => 'relevance',
            'maxResults'  => min($perPage, 40),
            'startIndex'  => $startIndex,
            // 'key'      => env('GOOGLE_BOOKS_API_KEY') // opcional
        ])->throw()->json();

        $items = $resp['items'] ?? [];
        $out = [];
        foreach ($items as $it) {
            $id   = $it['id'] ?? '';
            $vol  = $it['volumeInfo'] ?? [];
            $title= $vol['title'] ?? '';
            $authors = $vol['authors'] ?? [];
            $desc = $vol['description'] ?? null;
            $lang = $vol['language'] ?? null;
            $ids  = $vol['industryIdentifiers'] ?? [];
            $isbn13 = null;
            foreach ($ids as $idobj) {
                if (($idobj['type'] ?? '') === 'ISBN_13') { $isbn13 = $idobj['identifier']; break; }
            }
            $thumb = $vol['imageLinks']['thumbnail'] ?? null;

            $out[] = new RawBookDTO(
                externalId: $id,
                title: $title,
                authors: $authors,
                description: $desc,
                language: $lang,
                isbn13: $isbn13,
                coverUrl: $thumb,
                categories: [$categorySlug],
                extra: ['google_categories'=>$vol['categories'] ?? []]
            );
        }
        return $out;
    }

    private function mapCategoryToQuery(string $slug): string
    {
        return match ($slug) {
            'literatura-y-ficcion' => 'fiction',
            'libros-universitarios-y-de-estudios-superiores' => 'textbooks',
            'lengua-linguistica-y-redaccion' => 'linguistics',
            'sociedad-y-ciencias-sociales' => 'social science',
            'historia' => 'history',
            'salud-familia-y-desarrollo-personal' => 'self-help',
            'romantica' => 'romance',
            'fantasia-y-ciencia-ficcion' => 'science fiction',
            'arte-y-fotografia' => 'art',
            'biografias-diarios-y-hechos-reales' => 'biography',
            'infantil' => 'children',
            'ciencias-tecnologia-y-medicina' => 'science',
            'non-fiction' => 'non_fiction',
            'fantasy' => 'fantasy',
            'mystery' => 'mystery',
            'romance' => 'romance',
            'thriller' => 'thriller',
            'biography' => 'biography',
            'business' => 'business',
            'programming' => 'programming',
            'science' => 'science',
            'philosophy' => 'philosophy',
            'poetry' => 'poetry',
            default => $slug,
        };
    }
}
