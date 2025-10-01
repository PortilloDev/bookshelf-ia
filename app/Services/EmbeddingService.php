<?php
namespace App\Services;

use App\Models\QueryEmbedding;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class EmbeddingService
{
    private string $provider;
    private string $model;
    private ?string $openaiKey;
    private ?string $googleKey;

    public function __construct()
    {
        $this->provider = config('services.embeddings.provider', 'openai');
        $this->model    = config('services.embeddings.model', 'text-embedding-3-small');
        $this->openaiKey = config('services.openai.key');
        $this->googleKey = config('services.google_ai.key');
    }

    /* ------------- Normalización ------------- */
    public static function normalize(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/u', ' ', $text);
        return mb_strtolower($text, 'UTF-8');
    }

    /* ------------- Públicos ------------- */
    public function embedDocument(string $text): array
    {
        if ($this->provider === 'google') {
            return $this->embedGoogleWithTaskType($text, 'RETRIEVAL_DOCUMENT');
        }
        return $this->embedOpenAI($text);
    }

    public function embedQuery(string $text): array
    {
        if ($this->provider === 'google') {
            return $this->embedGoogleWithTaskType($text, 'RETRIEVAL_QUERY');
        }
        return $this->embedOpenAI($text);
    }

    /** Embedding de query con cache y TTL (por defecto 48 h). */
    public function embedQueryCached(string $query, int $ttlSeconds = 172800): array
    {
        $qNorm = self::normalize($query);
        $hash = hash('sha256', implode('|', [$qNorm, $this->model, $this->provider, 'QUERY']));

        // ¿en cache y sin expirar?
        $row = QueryEmbedding::where('hash', $hash)
            ->where(function($q){ $q->whereNull('expires_at')->orWhere('expires_at','>', now()); })
            ->first();

        if ($row) {
            return $this->literalToArray($row->vector_literal);
        }

        // calcular y guardar
        $vec = $this->embedQuery($qNorm);
        $literal = '['.implode(',', $vec).']';

        QueryEmbedding::updateOrCreate(
            ['hash' => $hash],
            [
                'query_norm'     => $qNorm,
                'provider'       => $this->provider,
                'model'          => $this->model,
                'dim'            => count($vec),
                'vector_literal' => $literal,
                'expires_at'     => now()->addSeconds($ttlSeconds),
            ]
        );

        return $vec;
    }

    /* ------------- Proveedores ------------- */
    private function embedOpenAI(string $text): array
    {
        if (!$this->openaiKey) throw new RuntimeException('OPENAI_API_KEY no configurada.');

        $resp = Http::withToken($this->openaiKey)
            ->asJson()
            ->post('https://api.openai.com/v1/embeddings', [
                'model' => $this->model,
                'input' => $text,
            ]);

        if ($resp->failed()) {
            throw new RuntimeException('OpenAI error: '.$resp->status().' '.$resp->body());
        }

        $json = $resp->json();
        $vec  = $json['data'][0]['embedding'] ?? null;
        if (!is_array($vec)) {
            throw new RuntimeException('OpenAI: respuesta sin "data[0].embedding": '.$resp->body());
        }
        return array_map('floatval', $vec);
    }

    private function embedGoogleWithTaskType(string $text, string $taskType): array
    {
        if (!$this->googleKey) throw new RuntimeException('GOOGLE_AI_API_KEY no configurada.');

        $url = "https://generativelanguage.googleapis.com/v1beta/{$this->model}:embedContent?key={$this->googleKey}";
        $payload = [
            'content'  => ['parts' => [['text' => $text]]],
            'taskType' => $taskType,
        ];

        $resp = Http::asJson()->post($url, $payload);
        if ($resp->failed()) throw new RuntimeException('Google AI error: '.$resp->status().' '.$resp->body());

        $json = $resp->json();
        if (isset($json['error'])) throw new RuntimeException('Google AI error JSON: '.json_encode($json['error']));

        $vec = data_get($json, 'embedding.values') ?? data_get($json, 'embedding.value');
        if (!is_array($vec)) throw new RuntimeException('Google AI: respuesta sin vector: '.json_encode($json));

        return array_map('floatval', $vec);
    }

    /* ------------- Util ------------- */
    private function literalToArray(string $literal): array
    {
        $literal = trim($literal, "[] \t\n\r\0\x0B");
        if ($literal === '') return [];
        return array_map('floatval', explode(',', $literal));
    }
}
