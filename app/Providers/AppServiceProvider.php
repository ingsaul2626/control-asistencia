<?php

namespace App\Providers;


use Illuminate\Support\Facades\Auth;
use App\Models\Actividad;
// Los que ya tenías
use App\Events\UserRegistered;
use App\Listeners\LogUserRegistration;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Compartir notificaciones con todas las vistas
        View::composer('*', function ($view) {
    if (Auth::check()) {
        // Obtenemos las notificaciones
        $notifs = Actividad::where('user_id', Auth::id())
            ->latest()
            ->take(10)
            ->get();

        // CONTADOR: Solo las que tienen leido = 0
        // Este es el número que aparece en el círculo rojo (+9)
        $conteo_unread = Actividad::where('user_id', Auth::id())
            ->where('leido', 0)
            ->count();

        $view->with([
            'notifs' => $notifs,
            'conteo_unread' => $conteo_unread
        ]);
    }
});

        // CONEXIÓN DEL EVENTO
        Event::listen(
            UserRegistered::class,
            LogUserRegistration::class,
        );

        // Observers que ya tenías
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Asistencia::observe(\App\Observers\AsistenciaObserver::class);
        \App\Models\Proyecto::observe(\App\Observers\ProyectoObserver::class);

        // Tu código de HTTPS para los túneles
        if (str_contains(config('app.url'), 'devtunnels.ms')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }


}
