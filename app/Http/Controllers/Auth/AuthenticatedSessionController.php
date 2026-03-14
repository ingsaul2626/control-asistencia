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
    // 1. VALIDACIÓN DEL RECAPTCHA (Esto está bien)
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

    // 2. AUTENTICACIÓN
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // 3. FILTRO: Estado de aprobación (CORREGIDO)
    // Usamos el campo booleano is_approved
    if (!(bool)$user->is_approved) {
        Auth::logout();
        return redirect()->route('waiting-approval')
                         ->with('error', 'Tu cuenta está pendiente de aprobación.');
    }

    // 4. REGISTRO EN BITÁCORA
    Bitacora::create([
        'user_id' => $user->id,
        'accion' => 'Inicio de sesión',
        'detalles' => 'El usuario ha ingresado al sistema con éxito.',
        'ip' => $request->ip(),
    ]);

    // 5. REDIRECCIÓN SEGÚN ROL
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->intended(route('dashboard', absolute: false));
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
