<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Proyecto;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{


        $hoy = now()->toDateString();

        // 1. Cálculos de Asistencia y Usuarios
        $totalUsuarios = User::where('role', 'user')->count();
        $asistenciasHoy = Asistencia::whereDate('fecha', $hoy)->get();

        $conteoPresentes = $asistenciasHoy->whereIn('status', ['presente', 'en_progreso', 'finalizado'])->count();
        $conteoAusentes = $asistenciasHoy->where('status', 'ausente')->count();

        $idsConCualquierRegistro = $asistenciasHoy->pluck('user_id');

        $usuariosPendientes = User::where('role', 'user')
                            ->whereNotIn('id', $idsConCualquierRegistro)
                            ->get();

        $conteoPendientes = $usuariosPendientes->count();

        // Obtener los modelos de usuarios que están ausentes
        $usuariosAusentes = User::whereIn('id',
            $asistenciasHoy->where('status', 'ausente')->pluck('user_id')
        )->get();

        $porcentajeAsistencias = $totalUsuarios > 0
            ? round(($conteoPresentes / $totalUsuarios) * 100)
            : 0;

        $proyectosActivos = Proyecto::where('activo', 1)->count();
        $proyectosInactivos = Proyecto::where('activo', 0)->count();


        $proyectosData = [

            'completados' => 0,
            'en_progreso' => $proyectosActivos,
            'pendientes'  => $proyectosInactivos,
        ];

        // --- 3. Top Usuarios ---
        $topUsuarios = User::withCount('proyectos')
            ->orderBy('proyectos_count', 'desc')
            ->take(5)
            ->get();




        // 3. RETORNO ÚNICO (Al final de la función, con todas las variables)
        return view('dashboard', compact(
            'totalUsuarios',
            'conteoPresentes',
            'conteoAusentes',
            'conteoPendientes',
            'porcentajeAsistencias',
            'usuariosAusentes',
            'usuariosPendientes',
            'proyectosData',
            'topUsuarios'
        ));
    }
}

