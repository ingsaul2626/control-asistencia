<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Bitacora;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    // 1. VALIDACIÓN DEL RECAPTCHA
    if ($request->has('g-recaptcha-response')) {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('NOCAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'La verificación falló. Inténtalo de nuevo.',
            ]);
        }
    }

    try {
        // 2. INTENTO DE AUTENTICACIÓN
        $request->authenticate();

        $user = Auth::user();

        // 3. VERIFICAR SI ESTÁ APROBADO O BLOQUEADO
        if (!(bool)$user->is_approved) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Tu cuenta está bloqueada o pendiente de aprobación. Contacta al admin.');
        }

        // Si el login es exitoso, reiniciamos la sesión
        $request->session()->regenerate();

        // 4. REGISTRO EN BITÁCORA
        Bitacora::create([
            'user_id' => $user->id,
            'accion' => 'Inicio de sesión',
            'detalles' => 'El usuario ha ingresado al sistema con éxito.',
            'ip' => $request->ip(),
        ]);

        // 5. REDIRECCIÓN SEGÚN ROL
        return $user->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->intended(route('dashboard', absolute: false));

    } catch (ValidationException $e) {
        // --- LÓGICA DE BLOQUEO POR INTENTOS ---

        // Buscamos si el usuario existe por el email ingresado
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && (bool)$user->is_approved) {
            // Usamos el RateLimiter de Laravel para contar intentos por IP/Email
            $attempts = \Illuminate\Support\Facades\RateLimiter::attempts($request->throttleKey());

            if ($attempts >= 3) {
                $user->update(['is_approved' => false]); // Lo bloqueamos

                // Opcional: Registrar el bloqueo en la bitácora
                Bitacora::create([
                    'user_id' => $user->id,
                    'accion' => 'Bloqueo de cuenta',
                    'detalles' => 'Cuenta bloqueada tras 3 intentos fallidos.',
                    'ip' => $request->ip(),
                ]);

                throw ValidationException::withMessages([
                    'email' => 'Tu cuenta ha sido bloqueada por demasiados intentos fallidos. Contacta al administrador.',
                ]);
            }
        }

        // Si no ha llegado a 3, relanzamos la excepción normal de Laravel
        throw $e;
    }
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
