<?php

namespace App\Services\Ingest;

use App\Models\BookRaw; // tu modelo (table book_raw)
use Illuminate\Support\Str;

class BookIngestService
{
    /** @param BookSourceAdapterInterface[] $adapters */
    public function __construct(private array $adapters) {}

    public function fetchAndStore(string $source, string $categorySlug, int $page, int $perPage): int
    {
        $adapter = collect($this->adapters)->first(fn($a)=>$a->getSourceName()===$source);
        if (!$adapter) throw new \RuntimeException("Fuente no soportada: $source");

        $batch = $adapter->fetchByCategory($categorySlug, $page, $perPage);
        $n=0;
        foreach ($batch as $dto) {
            $payload = [
                'title'=>$dto->title, 'authors'=>$dto->authors, 'description'=>$dto->description,
                'language'=>$dto->language, 'isbn13'=>$dto->isbn13, 'cover_url'=>$dto->coverUrl,
                'categories'=>$dto->categories, 'extra'=>$dto->extra,
            ];
            $checksum = hash('sha256', json_encode($payload));
            BookRaw::updateOrCreate(
                ['source'=>$source,'external_id'=>$dto->externalId],
                [
                    'payload_json'=>$payload,
                    'checksum'=>$checksum,
                    'status'=>'fetched',
                    'fetched_at'=>now(),
                ]
            );
            $n++;
        }
        return $n;
    }
}