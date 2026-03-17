<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function reporteHoy()
    {
        $fechaHoy = now()->format('Y-m-d');

        // 1. Obtener proyectos activos o que inician hoy con sus responsables
        // Usamos 'user' porque en tu tabla proyectos la columna es 'user_id'
        $proyectos = Proyecto::with('user')
            ->whereDate('fecha_inicio', '<=', $fechaHoy)
            ->where('activo', 1)
            ->get();

        // 2. Obtener las asistencias del día con la info de los usuarios (Nombre, Cédula, etc.)
        // Esto traerá los datos de trabajadores como Gerardo Lopez o Zully Reyes
        $asistencias = Asistencia::with('user')
            ->whereDate('fecha', $fechaHoy)
            ->get();

        // 3. Cargar la vista pasando ambas colecciones
        $pdf = Pdf::loadView('admin.reportes.pdf_asistencia', [
            'proyectos'   => $proyectos,
            'asistencias' => $asistencias,
            'fechaHoy'    => $fechaHoy
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("reporte_general_{$fechaHoy}.pdf");
    }
}
