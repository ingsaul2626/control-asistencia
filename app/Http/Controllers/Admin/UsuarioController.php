<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = \App\Models\User::all();
        $usuarios = User::all();
        $usuarios = User::where('id', '!=', Auth::id())->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function toggleAdmin($id) {
    $user = User::findOrFail($id);
    $user->role = ($user->role === 'admin') ? 'user' : 'admin';
    $user->save();
    return back()->with('success', 'Rol actualizado.');
}




    // usuario crud

    public function store(Request $request)
{
    // 1. Validar los datos
    $request->validate([
        'name'      => 'required|string|max:255',
        'cedula'    => 'required|string|max:8|unique:users',
        'email'     => 'required|email|unique:users',
        'role'      => 'required|string',
        'cargo'     => 'nullable|string', // Asegúrate de que esto coincida con tu base de datos
        'password'  => 'required|min:8|confirmed',
        'security_question' => 'required|string',
        'security_answer'   => 'required|string',
        'telefono'  => 'required|string|max:11',
    ]);

    // 2. Crear el usuario
    User::create([
        'name'              => $request->name,
        'cedula'            => $request->cedula,
        'email'             => $request->email,
        'role'              => $request->role,
        'cargo'             => $request->cargo,
        'telefono'          => $request->telefono,
        'security_question' => $request->security_question,
        'security_answer'   => $request->security_answer,
        'password'          => Hash::make($request->password),
    ]);

    // 3. Redirigir
    return redirect()->route('admin.usuarios.index')
                     ->with('success', 'Usuario registrado exitosamente.');
}

    public function update(Request $request, $id)
    {
        // 1. Validar los datos que vienen del formulario
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|string',
            'status' => 'nullable|string',
        ]);

        // 2. Buscar al usuario
        $usuarios = User::findOrFail($id);

        // 3. Actualizar los campos
        // Usamos $request->only para mayor seguridad, o $request->all() si prefieres
        $usuarios->update($request->all());

        // 4. Redirigir con mensaje de éxito
        return redirect()->route('admin.usuarios.index')
                        ->with('success', 'Usuario actualizado correctamente.');
    }

    public function show($id)
    {
        $usuarios = \App\Models\User::findOrFail($id);
        return view('admin.usuarios.show', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuarios = \App\Models\User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuarios'));
    }

    public function destroy($id)
{

    $usuario = \App\Models\User::findOrFail($id);
    $usuario->delete();

    // Redirigir con mensaje de éxito
    return redirect()->route('admin.usuarios.index')
                     ->with('success', 'Usuario eliminado correctamente.');
}




// NUEVO: Método para aprobar usuarios

  public function approve($id) {
    $user = User::findOrFail($id);
    $user->update(['is_approved' => 1, 'status' => 'APROBADO']);
    return back()->with('success', 'Usuario aprobado.');
}

    // NUEVO: Método para rechazar usuarios
public function decline($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->update(['status' => 'declined']);

    return back()->with('success', 'Usuario rechazado.');
}

    // NUEVO: Asegúrate de tener el método destroy si usas el botón de eliminar estándar

    public function create()
{
    // Asegúrate de que esta vista exista en:
    // resources/views/admin/usuarios/create.blade.php
    return view('admin.usuarios.create');
}
}
