<?php

namespace App\Models\Dto;

class RawBookDTO
{
    public function __construct(
        public string $externalId,
        public string $title,
        public array  $authors = [],      // strings
        public ?string $description = null,
        public ?string $language = null,  // 'es' preferente
        public ?string $isbn13 = null,
        public ?string $coverUrl = null,
        public array $categories = [],    // slugs/labels de la fuente
        public array $extra = [],         // JSON libre (rating, páginas, fecha…)
    ) {}
}