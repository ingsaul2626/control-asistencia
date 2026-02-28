<?php

namespace App\Http\Controllers\Auth; // <-- Solo debe quedar este namespace

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PasswordResetLinkController extends Controller
{
    /**
     * MUESTRA LA VISTA (Este es el método que te faltaba y causaba el error)
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * PROCESA LA SOLICITUD
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validamos el formato del correo
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // 2. Buscamos al usuario
        $user = User::where('email', $request->email)->first();

        // 3. Si no existe, error
        if (!$user) {
            return back()->withErrors([
                'email' => 'No pudimos encontrar una cuenta con esa dirección de correo electrónico.',
            ]);
        }

        // 4. Generamos el Token de seguridad
        $token = Password::createToken($user);

        // 5. Redirección directa a la vista de "Reset" (Saltando el envío de correo)
        // Asegúrate de que tu ruta 'password.reset' reciba estos parámetros
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }
}
