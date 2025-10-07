<?php

namespace App\Providers;


use App\Services\Ingest\BookIngestService;
use App\Services\Ingest\GoogleBooksAdapter;
use App\Services\Ingest\OpenLibraryAdapter;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookIngestService::class, function($app){
            return new BookIngestService([
                new OpenLibraryAdapter(),
                new GoogleBooksAdapter(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('embeddings', function () {
            // Ajusta a tu cuota: p.ej. 60/minuto por proyecto
            return [ Limit::perMinute(60) ];
        });
    }
}
