<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Muestra la vista de restablecimiento de contraseña.
     */
    public function create(Request $request): View
    {
        // Pasamos el token y el email a la vista
        return view('auth.reset-password', [
            'request' => $request,
            'token' => $request->route('token'),
            'email' => $request->email,
        ]);
    }

    /**
     * Procesa el cambio de contraseña con validación de seguridad.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'security_answer' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        // 1. Validar si el usuario existe y si la respuesta coincide (ignore case)
        if (!$user || strtolower($user->security_answer) !== strtolower($request->security_answer)) {
            return back()->withErrors([
                'security_answer' => 'La respuesta de seguridad es incorrecta.'
            ])->withInput($request->only('email'));
        }

        // 2. Actualizar contraseña y limpiar tokens
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // 3. Opcional: Disparar evento de contraseña restablecida
        // event(new \Illuminate\Auth\Events\PasswordReset($user));

        return redirect()->route('login')->with('status', 'Tu contraseña ha sido actualizada con éxito.');
    }
}
