<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
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
    \App\Models\Proyecto::observe(\App\Observers\ProyectoObserver::class);
    if (str_contains(config('app.url'), 'devtunnels.ms')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
        User::observe(UserObserver::class);
    }
}
}
