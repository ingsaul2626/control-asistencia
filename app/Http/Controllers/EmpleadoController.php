<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asistencia;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class usuariosController extends Controller
{
    public function index()
    {
        $usuarioss = User::where('role', 'user')->get();
        $asistenciasHoy = Asistencia::whereDate('fecha', Carbon::today())->get();

        // CAMBIO: Asegúrate de que este archivo esté en: resources/views/admin/usuarios/index.blade.php
        return view('admin.usuarios.index', compact('usuarios', 'asistenciasHoy'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->merge(['cedula' => preg_replace('/[^0-9]/', '', $request->cedula)]);

        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:7,8', 'unique:users,cedula'],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cedula' => $request->cedula,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'tipo_trabajador' => $request->tipo_trabajador,
            'seccion' => $request->seccion,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'usuarios registrado con éxito.');
    }

    public function show($id)
    {
        $usuarios = User::with(['asistencias' => function($query) {
            $query->orderBy('fecha', 'desc')->limit(10);
        }])->findOrFail($id);

        return view('admin.usuarios.show', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuarios = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuarios'));
    }

    public function update(Request $request, $id)
    {
        $usuarios = User::findOrFail($id);
        $request->merge(['cedula' => preg_replace('/[^0-9]/', '', $request->cedula)]);

        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:7,8', Rule::unique('users')->ignore($id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
        ]);

        $data = $request->only(['name', 'email', 'cedula', 'tipo_trabajador', 'seccion']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuarios->update($data);
        return redirect()->route('admin.usuarios.index')->with('success', 'Datos actualizados.');
    }

    public function destroy($id)
    {
        $usuarios = User::findOrFail($id);
        $usuarios->delete();
        return redirect()->route('admin.usuarios.index')->with('delete', "usuarios eliminado.");
    }

    public function finalizarJornada(Request $request, $id)
    {
        $asistencia = Asistencia::where('user_id', $id)
            ->whereDate('fecha', Carbon::today())
            ->whereNull('hora_salida')
            ->first();

        if ($asistencia) {
            $asistencia->update([
                'hora_salida' => Carbon::now()->format('H:i:s'),
                'observaciones' => ($asistencia->observaciones ?? '') . ' | Jornada cerrada por Admin'
            ]);

            return back()->with('success', 'Jornada finalizada con éxito.');
        }

        return back()->with('error', 'No se encontró una jornada activa para hoy o ya fue cerrada.');
    }

    public function enviarReporte(Request $request, $id)
{
    // 1. Validar que el texto no sea malicioso y tenga contenido
    $request->validate([
        'reporte_trabajador' => 'required|string|max:1000',
    ]);

    // 2. Buscar el proyecto asignado
    $proyecto = \App\Models\Evento::findOrFail($id);

    // 3. Guardar el avance técnico
    $proyecto->reporte_trabajador = $request->reporte_trabajador;
    $proyecto->save();

    return redirect()->back()->with('success', 'Reporte enviado correctamente.');
}
}
