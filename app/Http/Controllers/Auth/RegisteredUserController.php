<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Maneja la solicitud de registro entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validación de campos actualizada
        $request->validate([
            'cedula' => ['required', 'string', 'max:8', 'unique:users,cedula'],
            'cargo' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:11'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'security_question' => ['required', 'string'],
            'security_answer' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo_trabajador' => ['required', 'string'],
        ]);

        // 2. Creación del usuario con los nuevos campos
        $user = User::create([
            'cedula' => $request->cedula,
            'cargo' => $request->cargo,
            'telefono' => $request->telefono,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'security_question' => $request->security_question,
            'security_answer' => strtolower($request->security_answer),
            'tipo_trabajador' => $request->tipo_trabajador,
            'seccion' => $request->seccion,
            
        ]);

        // 3. Disparar evento de registro, login y redirección
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
