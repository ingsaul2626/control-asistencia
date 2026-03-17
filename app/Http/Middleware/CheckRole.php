<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificamos si el usuario está autenticado usando la Fachada
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Verificamos el rol
        if (Auth::user()->role !== $role) {
            // Si no tiene el rol, al dashboard (asegúrate que la ruta 'dashboard' exista)
            return redirect('/dashboard')->with('error', 'No tienes permiso para acceder a esta área.');
        }

        return $next($request);
    }
}
