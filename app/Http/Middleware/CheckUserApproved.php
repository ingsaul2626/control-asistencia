<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // 1. Si no hay usuario logueado, dejamos que el sistema continúe
        // (esto suele ir hacia el middleware 'auth' que lo enviará al login)
        if (!$user) {
            return $next($request);
        }

        // 2. Si el usuario es administrador, tiene paso libre a todo
        if ($user->role === 'admin') {
            return $next($request);
        }

        // 3. Verificamos si el estatus NO es 'APROBADO'
        if ($user->status !== 'APROBADO') {

            // Si el usuario ya está en la vista de espera, lo dejamos estar ahí
            // Esto es CRUCIAL para evitar el error de "demasiadas redirecciones"
            if ($request->routeIs('waiting-approval')) {
                return $next($request);
            }

            // Si intenta entrar a cualquier otra parte, lo redirigimos a espera
            return redirect()->route('waiting-approval');
        }

        // 4. Si el status es 'APROBADO', dejamos que acceda a su destino original
        return $next($request);
    }
}
