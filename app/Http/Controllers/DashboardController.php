<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $totalTrabajadores = Empleado::count();
    $asistenciasHoy = Asistencia::whereDate('created_at', now()->today())->count();
    $asistenciasHoy = Asistencia::whereDate('created_at', today())->get();
    $conteoPresentes = $asistenciasHoy->where('status', 'presente')->count();
    $faltasHoy = $totalTrabajadores - $asistenciasHoy;
    $conteoFaltasMarcadas = $asistenciasHoy->where('status', 'ausente')->count();
    $totalEmpleados = Empleado::count();
    $conteoSinRegistro = $totalEmpleados - $asistenciasHoy->count();
    $empleadosAusentes = Empleado::whereNotIn('id', $asistenciasHoy->where('status', 'presente')->pluck('empleado_id'))->get();
    return view('dashboard', compact('asistenciasHoy', 'faltasHoy', 'totalTrabajadores'));
    $hoy = now()->toDateString();
    $asistentesIds = Asistencia::where('fecha', $hoy)
    ->where('status', 'presente')
    ->pluck('empleado_id');
    $empleadosAusentes = Empleado::whereNotIn('id', $asistentesIds)->get();
    $conteoPresentes = $asistentesIds->count();
    $conteoAusentes = $empleadosAusentes->count();
}

}
