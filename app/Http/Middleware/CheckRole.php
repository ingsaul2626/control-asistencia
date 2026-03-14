<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificamos si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Verificamos el rol
        // Nota: Asegúrate de que 'role' sea el nombre de la columna en tu tabla users
        if (auth()->user()->role !== $role) {
            // En lugar de abortar, a veces es mejor redirigir al dashboard con un mensaje
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta área.');
        }

        return $next($request);
    }
}
