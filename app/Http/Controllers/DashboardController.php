<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\User as Usuarios;

class DashboardController extends Controller
{
   public function index()
    {
        $hoy = now()->toDateString();

    // 1. Inicializamos todas las variables necesarias

    $totalUsuarios = Usuarios::count();
    $asistenciasHoy = Asistencia::whereDate('created_at', $hoy)->get();

    // 2. Definimos las variables con valores por defecto para evitar errores
    $conteoPresentes = $asistenciasHoy->where('status', 'presente')->count();
    $conteoFaltasMarcadas = $asistenciasHoy->where('status', 'ausente')->count();

    // 3. Aseguramos que $usuariosAusentes SIEMPRE exista
    $asistentesIds = $asistenciasHoy->where('status', 'presente')->pluck('usuarios_id');
    $usuariosAusentes = Usuarios::whereNotIn('id', $asistentesIds)->get();

    $conteoAusentes = $usuariosAusentes->count();
    $faltasHoy = $totalUsuarios - $conteoPresentes;
    $conteoSinRegistro = $totalUsuarios - $asistenciasHoy->count();

    $porcentajeAsistencias = ($totalUsuarios > 0)
        ? round(($conteoPresentes / $totalUsuarios) * 100, 2)
        : 0;
    $conteoPendientes = $totalUsuarios - ($conteoPresentes + $conteoAusentes);

    // 4. Compact enviará todas, incluso si alguna está vacía
   return view('dashboard', compact(
        'asistenciasHoy',
        'faltasHoy',
        'totalUsuarios', // <--- CAMBIA 'totalusuarios' POR ESTO
        'conteoPresentes',
        'conteoFaltasMarcadas',
        'conteoSinRegistro',
        'usuariosAusentes',
        'conteoAusentes',
        'porcentajeAsistencias',
        'conteoPendientes'
    ));
}
}
