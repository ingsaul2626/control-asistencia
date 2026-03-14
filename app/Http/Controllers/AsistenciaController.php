<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $fecha = date('Y-m-d');
        $fecha = $request->get('fecha', now()->toDateString());
        $users = \App\Models\User::where('role', 'user')->get();
        $asistenciasHoy = \App\Models\Asistencia::where('fecha', $fecha)->get()->keyBy('user_id');
        return view('asistencias.index', compact('users', 'fecha', 'asistenciasHoy'));
}


    /**
     * ACCIÓN DEL ADMIN: Asigna horario inicial.
     * Estatus resultante: 'finalizado' (pero sin hora de salida, lo que indica "esperando usuarios").
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'hora_entrada' => 'nullable',
            'hora_salida'  => 'nullable',
            'fecha'        => 'nullable|date',
        ]);

        $fechaFinal = $request->fecha ?: now()->toDateString();
        $asistencia = Asistencia::where('user_id', $request->user_id)
                                ->whereDate('fecha', $fechaFinal)
                                ->first();

        // Determinamos el estatus basado en el botón de Falta
        $status = ($request->es_falta == "1") ? 'ausente' : 'finalizado';

        $data = [
            'user_id'       => $request->user_id,
            'fecha'         => $fechaFinal,
            'status'        => $status,
            'observaciones' => $request->observaciones,
            'hora_entrada'  => $request->hora_entrada ?: ($asistencia->hora_entrada ?? now()->format('H:i')),
            'hora_salida'   => $request->hora_salida ?: ($asistencia->hora_salida ?? null),
        ];

        if ($status === 'ausente') {
            $data['hora_entrada'] = null;
            $data['hora_salida'] = null;
        }

        if ($asistencia) {
            $asistencia->update($data);
            $msg = "Registro actualizado.";
        } else {
            Asistencia::create($data);
            $msg = "Horario asignado.";
        }

        return back()->with('success', $msg);
    }

    /**
     * ACCIÓN DEL usuarios: Acepta el horario.
     * Estatus resultante: 'en_progreso' (Punto verde animado para el admin).
     */
    public function aceptarAsistencia($id)
{
    $asistencia = Asistencia::findOrFail($id);

    // El usuario acepta y fijamos la hora real de entrada
    $asistencia->update([
        'status' => 'aceptado',
        'hora_entrada_real' => now()->format('H:i:s'),
    ]);

    return back()->with('success', '¡Has aceptado tu jornada correctamente!');
}

public function marcarSalida($id)
{
    $asistencia = Asistencia::findOrFail($id);

    $asistencia->update([
        'status' => 'finalizado',
        'hora_salida' => now()->format('H:i:s'),
    ]);

    return back()->with('success', 'Jornada finalizada con éxito.');
}

    /**
     * ACCIÓN RÁPIDA: Marcar falta desde el Admin.
     */
    public function marcarFalta(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        Asistencia::updateOrCreate(
            ['user_id' => $request->user_id, 'fecha' => now()->toDateString()],
            ['status' => 'ausente', 'hora_entrada' => null, 'hora_salida' => null]
        );

        return back()->with('success', 'Se ha registrado la falta.');
    }
}
