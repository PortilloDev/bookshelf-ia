<?php

namespace App\Services\Ingest;

use App\Models\Dto\RawBookDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OpenLibraryAdapter implements BookSourceAdapterInterface
{
    private const OPEN_LIBRARY_NAME = 'open_library';
    public function getSourceName(): string
    {
        return self::OPEN_LIBRARY_NAME;
    }

    public function fetchByCategory(string $categorySlug, int $page=1, int $perPage=40): array
    {
        // Heurística: usar endpoint de subjects
        $subject = $this->mapCategoryToSubject($categorySlug);
        $offset  = ($page-1) * $perPage;

        $resp = Http::retry(3, 500)->get("https://openlibrary.org/subjects/{$subject}.json", [
            'limit' => $perPage,
            'offset'=> $offset,
        ])->throw()->json();

        $works = $resp['works'] ?? [];
        $out = [];
        foreach ($works as $w) {
            $title   = $w['title'] ?? '';
            $authors = array_map(fn($a)=>$a['name'] ?? '', $w['authors'] ?? []);
            $olid    = $w['key'] ?? '';               // ej: "/works/OL12345W"
            $coverId = $w['cover_id'] ?? null;
            $cover   = $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg" : null;

            $out[] = new RawBookDTO(
                externalId: ltrim($olid,'/'),
                title: $title,
                authors: array_values(array_filter($authors)),
                description: null,          // luego lo podemos enriquecer si hace falta
                language: null,             // Open Library en subject no siempre da idioma
                isbn13: null,               // opcional: enriquecer después con /works/OL... json
                coverUrl: $cover,
                categories: [$categorySlug],
                extra: ['subject'=>$subject]
            );
        }
        return $out;
    }

    private function mapCategoryToSubject(string $slug): string
    {
        return match ($slug) {
            'literatura-y-ficcion', 'fiction' => 'fiction',
            'libros-universitarios-y-de-estudios-superiores' => 'textbooks',
            'lengua-linguistica-y-redaccion' => 'language',
            'sociedad-y-ciencias-sociales' => 'social_sciences',
            'historia', 'history' => 'history',
            'salud-familia-y-desarrollo-personal', 'self-help' => 'self-help',
            'romantica' => 'romance',
            'fantasia-y-ciencia-ficcion', 'science-fiction' => 'science_fiction', // o 'fantasy'
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
            default => Str::slug($slug, '_'),
        };
    }
}
