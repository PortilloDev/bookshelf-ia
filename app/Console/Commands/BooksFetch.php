<?php

namespace App\Console\Commands;

use App\Services\Ingest\BookIngestService;
use Illuminate\Console\Command;

class BooksFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:fetch 
    {source : open_library|google_books} 
    {category=all : slug de categoría o "all"} 
    {--pages=3} {--per=40}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Descarga libros por categoría a book_raw (crudos)';

    /**
     * Execute the console command.
     */
    public function handle(BookIngestService $svc): int
    {
        $source = $this->argument('source');
        $cat    = $this->argument('category');
        $pages  = (int)$this->option('pages');
        $per    = (int)$this->option('per');

        $cats = $cat==='all'
            ? \DB::table('categories')->pluck('slug')->all()
            : [$cat];

        $total=0;
        foreach ($cats as $slug) {
            for ($p=1; $p<=$pages; $p++) {
                $n = $svc->fetchAndStore($source, $slug, $p, $per);
                $total += $n;
                $this->info("{$source} :: {$slug} :: page {$p} -> {$n}");
                usleep(300_000); // respiro 300ms entre páginas
            }
        }
        $this->components->success("Total guardados/actualizados: {$total}");
        return self::SUCCESS;
    }
}

