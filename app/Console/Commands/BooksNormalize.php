<?php

namespace App\Console\Commands;

use App\Services\Ingest\BookNormalizer;
use Illuminate\Console\Command;

class BooksNormalize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:normalize {--limit=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Normaliza filas de book_raw y hace upsert en books';

    /**
     * Execute the console command.
     */
    public function handle(BookNormalizer $n): int
    {
        $nrm = $n->normalizePending((int)$this->option('limit'));
        $this->components->success("Normalizados: {$nrm}");
        return self::SUCCESS;
    }
}
