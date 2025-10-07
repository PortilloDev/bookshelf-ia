<?php

namespace App\Services\Ingest;

interface BookSourceAdapterInterface
{
    /**
     * Get the name of the external book source.
     *
     * @return string The name of the book source.
     */
    public function getSourceName(): string;
    /**
     * Fetch books by category from the external source.
     *
     * @param string $categorySlug The slug of the category to fetch books from.
     * @param int $page The page number for pagination (default is 1).
     * @param int $perPage The number of items per page (default is 40).
     * @return array An array of RawBookDTO objects representing the fetched books.
     */
    public function fetchByCategory(string $categorySlug, int $page=1, int $perPage=40): array;

}
