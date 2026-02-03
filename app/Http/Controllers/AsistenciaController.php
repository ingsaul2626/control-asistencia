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
        $fecha = $request->get('fecha', now()->toDateString());
        $empleados = User::where('role', 'user')->get();

        $asistenciasHoy = Asistencia::where('fecha', $fecha)
            ->get()
            ->keyBy('user_id');

        return view('asistencias.index', compact('empleados', 'asistenciasHoy', 'fecha'));
    }

    /**
     * ACCIÓN DEL ADMIN: Asigna horario inicial.
     * Estatus resultante: 'finalizado' (pero sin hora de salida, lo que indica "esperando usuario").
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
     * ACCIÓN DEL USUARIO: Acepta el horario.
     * Estatus resultante: 'en_progreso' (Punto verde animado para el admin).
     */
    public function aceptarHorario(Request $request)
    {
        $asistencia = Asistencia::where('user_id', auth()->id())
                                ->whereDate('fecha', now()->toDateString())
                                ->firstOrFail();

        $asistencia->update([
            'status' => 'en_progreso',
            'observaciones' => ($asistencia->observaciones ? $asistencia->observaciones . " | " : "") . "Turno iniciado por usuario."
        ]);

        return back()->with('success', '¡Jornada en progreso! Buen trabajo.');
    }

    /**
     * ACCIÓN DEL USUARIO: Marca salida.
     * Estatus resultante: 'finalizado' (Punto verde/azul fijo).
     */
    public function marcarSalidaUsuario(Request $request)
    {
        $asistencia = Asistencia::where('user_id', auth()->id())
                                ->whereDate('fecha', now()->toDateString())
                                ->firstOrFail();

        $asistencia->update([
            'hora_salida' => now()->format('H:i:s'),
            'status'      => 'finalizado'
        ]);

        return back()->with('success', 'Jornada finalizada correctamente.');
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
