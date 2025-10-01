<?php

namespace App\Providers;


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
        //
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
