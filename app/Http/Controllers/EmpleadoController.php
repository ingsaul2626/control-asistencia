<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Importante para manejo de fechas

class EmpleadoController extends Controller
{
    public function index()
    {
        // 1. Traemos usuarios con rol 'user'
        $empleados = User::where('role', 'user')->get();

        // 2. Obtenemos las asistencias de HOY para alimentar el indicador de estado
        // Esto soluciona el error "Undefined variable $asistenciasHoy"
        $asistenciasHoy = Asistencia::whereDate('fecha', Carbon::today())->get();

        // 3. Pasamos ambas variables a la vista
        return view('empleados.index', compact('empleados', 'asistenciasHoy'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        // Limpiamos la cédula de puntos o guiones antes de validar
        $request->merge([
            'cedula' => preg_replace('/[^0-9]/', '', $request->cedula)
        ]);

        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:7,8', 'unique:users,cedula'],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'tipo_trabajador' => 'required',
            'seccion' => 'required|string|max:100',
        ], [
            'cedula.unique' => '¡Atención! Esta cédula ya está registrada.',
            'cedula.digits_between' => 'La cédula debe tener 7 u 8 números.',
            'email.unique' => 'Este correo ya está en uso.',
            'required' => 'Este campo es obligatorio.'
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

        return redirect()->route('admin.empleados.index')->with('success', 'Trabajador registrado con éxito.');
    }

    public function show($id)
    {
        $empleado = User::with(['asistencias' => function($query) {
            $query->orderBy('fecha', 'desc')->limit(10);
        }])->findOrFail($id);

        return view('empleados.show', compact('empleado'));
    }

    public function edit($id)
    {
        $empleado = User::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = User::findOrFail($id);

        $request->merge([
            'cedula' => preg_replace('/[^0-9]/', '', $request->cedula)
        ]);

        $request->validate([
            'cedula' => ['required', 'numeric', 'digits_between:7,8', Rule::unique('users')->ignore($id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'tipo_trabajador' => 'required',
            'seccion' => 'required',
        ]);

        $data = $request->only(['name', 'email', 'cedula', 'tipo_trabajador', 'seccion']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $empleado->update($data);

        return redirect()->route('admin.empleados.index')->with('success', '¡Datos de ' . $empleado->name . ' actualizados!');
    }

    public function destroy($id)
    {
        $empleado = User::findOrFail($id);
        $nombre = $empleado->name;
        $empleado->delete();

        return redirect()->route('admin.empleados.index')->with('delete', "El trabajador $nombre ha sido eliminado.");
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
