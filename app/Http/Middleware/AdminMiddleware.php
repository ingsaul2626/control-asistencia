<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);
    $response->headers->set('bypass-tunnel-reminder', 'true');
    return $response;

    // Si el usuario es admin, déjalo pasar
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    // Si no, mándalo fuera con un 403
    abort(403, 'No tienes permiso para entrar aquí.');
}

}
