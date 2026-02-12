<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next) {
    if (auth()->check() && auth()->user()->role === 'super_admin') {
        return $next($request);
    }
    return redirect('/home')->with('error', 'No tienes permisos de Súper Admin.');
}
}
