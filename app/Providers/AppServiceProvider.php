<?php

namespace App\Providers;
use App\Observers\TrabajadorObserver;
use Illuminate\Support\ServiceProvider;

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
    // Si la URL del túnel está activa, obligamos a Laravel a usar HTTPS en todos los enlaces
    \App\Models\Evento::observe(\App\Observers\EventoObserver::class);
    if (str_contains(config('app.url'), 'devtunnels.ms')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
        Trabajador::observe(TrabajadorObserver::class);
    }
}
}
