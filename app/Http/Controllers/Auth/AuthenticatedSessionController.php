<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Bitacora; // 1. IMPORTANTE: Agregamos el modelo aquí
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 2. REGISTRAMOS EN LA BITÁCORA EL INICIO DE SESIÓN
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'Inicio de sesión',
            'detalles' => 'El usuario ha ingresado al sistema.',
            'ip' => $request->ip(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // 3. REGISTRAMOS EN LA BITÁCORA EL CIERRE DE SESIÓN (Antes de desloguear)
        if (Auth::check()) {
            Bitacora::create([
                'user_id' => Auth::id(),
                'accion' => 'Cierre de sesión',
                'detalles' => 'El usuario salió del sistema.',
                'ip' => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
