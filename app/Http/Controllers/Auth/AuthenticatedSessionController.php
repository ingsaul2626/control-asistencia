<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Bitacora;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Importante para la validación de Google
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. VALIDACIÓN DEL RECAPTCHA (Solo si hay internet)
        // Verificamos si se envió el campo desde el formulario
        // Dentro del método store
if ($request->has('g-recaptcha-response')) {
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret'   => env('NOCAPTCHA_SECRET'), // Usa la clave secreta nueva
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    // Si la respuesta no es exitosa, arroja el error de validación
    if (!$response->json('success')) {
        throw ValidationException::withMessages([
            'g-recaptcha-response' => 'La verificación falló. Inténtalo de nuevo.',
        ]);
    }
}

        // 2. AUTENTICACIÓN
        $request->authenticate();
        $request->session()->regenerate();

        // 3. REGISTRO EN BITÁCORA
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'Inicio de sesión',
            'detalles' => 'El usuario ha ingresado al sistema con éxito.',
            'ip' => $request->ip(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
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
