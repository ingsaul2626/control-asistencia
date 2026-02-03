<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        // Listamos todos los usuarios excepto al administrador actual
        $usuarios = User::where('id', '!=', auth()->id())->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function toggleAdmin(User $usuario)
    {
        // Si es admin lo vuelve user, y viceversa
        $usuario->role = ($usuario->role === 'admin') ? 'user' : 'admin';
        $usuario->save();

        return back()->with('success', 'Rol de usuario actualizado correctamente.');
    }
}
