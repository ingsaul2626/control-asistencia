<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    // ... index se mantiene igual ...
    public function index(Request $request)
{
    // 1. Obtener la fecha del request o usar la de hoy
    $fecha = $request->get('fecha', now()->toDateString());

    // 2. Obtener los usuarios (asegúrate de tener el modelo User importado)
    $User = \App\Models\User::where('role', 'user')->get();

    // 3. Obtener asistencias de esa fecha
    $asistenciasHoy = \App\Models\Asistencia::where('fecha', $fecha)->get()->keyBy('user_id');

    // 4. Retornar la vista pasando los datos
    return view('asistencias.index', compact('User', 'fecha', 'asistenciasHoy'));
}
    /**
     * ACCIÓN DEL ADMIN: Crea la jornada.
     * Ahora el estado por defecto es 'pendiente'.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'hora_entrada' => 'nullable',
            'fecha'        => 'nullable|date',
        ]);

        $fechaFinal = $request->fecha ?: now()->toDateString();

        // El admin crea la jornada, pero el status es 'pendiente'
        // para que el usuario sea quien la acepte y empiece a trabajar.
        $data = [
            'user_id'       => $request->user_id,
            'fecha'         => $fechaFinal,
            'status'        => ($request->es_falta == "1") ? 'ausente' : 'pendiente',
            'observaciones' => $request->observaciones,
            'hora_entrada'  => $request->hora_entrada,
            'hora_salida'   => null, // La salida la marca el usuario al finalizar
        ];

        Asistencia::updateOrCreate(
            ['user_id' => $request->user_id, 'fecha' => $fechaFinal],
            $data
        );

        return back()->with('success', 'Jornada planificada correctamente.');
    }

    /**
     * ACCIÓN DEL USUARIO: Acepta la jornada (Inicio real)
     */
    public function aceptarAsistencia($id)
    {
        $asistencia = Asistencia::findOrFail($id);

        $asistencia->update([
            'status'            => 'aceptado',
            'hora_entrada_real' => now()->format('H:i:s'),
        ]);

        return back()->with('success', '¡Jornada iniciada con éxito!');
    }

    /**
     * ACCIÓN DEL USUARIO: Finaliza su jornada
     */
    public function marcarSalida($id)
    {
        $asistencia = Asistencia::findOrFail($id);

        $asistencia->update([
            'status'      => 'finalizado',
            'hora_salida' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Jornada finalizada correctamente.');
    }


    /**
     * ACCIÓN DEL ADMIN: Marca a un usuario como ausente manualmente.
     */
    public function marcarFalta($id)
    {
        // 1. Buscamos al usuario
        $usuario = \App\Models\User::findOrFail($id);
        $fechaHoy = now()->toDateString();

        // 2. Creamos o actualizamos el registro como 'ausente'
        \App\Models\Asistencia::updateOrCreate(
            [
                'user_id' => $usuario->id,
                'fecha'   => $fechaHoy
            ],
            [
                'status'        => 'ausente',
                'observaciones' => 'Marcado como falta por el administrador',
                'hora_entrada'  => null
            ]
        );

        return back()->with('success', 'Falta registrada para ' . $usuario->name);
    }
}
