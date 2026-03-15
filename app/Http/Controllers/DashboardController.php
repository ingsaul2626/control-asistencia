<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\User as Usuarios;

class DashboardController extends Controller
{
   public function index()
{
    $hoy = now()->toDateString();

    // Consultas necesarias para la vista
    $totalUsuarios = \App\Models\User::where('role', 'user')->count();
    $asistenciasHoy = \App\Models\Asistencia::whereDate('fecha', $hoy)->get();

    $conteoPresentes = $asistenciasHoy->whereIn('status', ['presente', 'en_progreso', 'finalizado'])->count();
    $conteoAusentes = $asistenciasHoy->where('status', 'ausente')->count();

    $idsConCualquierRegistro = $asistenciasHoy->pluck('user_id');

    $usuariosPendientes = \App\Models\User::where('role', 'user')
                            ->whereNotIn('id', $idsConCualquierRegistro)
                            ->get();

    $conteoPendientes = $usuariosPendientes->count();

    $usuariosAusentes = \App\Models\User::whereIn('id',
        $asistenciasHoy->where('status', 'ausente')->pluck('user_id')
    )->get();

    $porcentajeAsistencias = $totalUsuarios > 0
        ? round(($conteoPresentes / $totalUsuarios) * 100)
        : 0;

    return view('dashboard', compact(
        'totalUsuarios',
        'conteoPresentes',
        'conteoAusentes',
        'conteoPendientes',
        'porcentajeAsistencias',
        'usuariosAusentes',
        'usuariosPendientes' // <--- ESTA ES LA VARIABLE QUE FALTABA
    ));
}
}
