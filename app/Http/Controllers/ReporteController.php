<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de tener instalado laravel-dompdf

class ReporteController extends Controller
{
    public function reporteHoy()
    {
        // 1. Obtener los eventos/asistencias de la fecha actual
        $fechaHoy = now()->format('Y-m-d');
        $asistencias = Evento::with('user')
            ->whereDate('fecha', $fechaHoy)
            ->get();

        // 2. Cargar la vista diseñada para el PDF
        $pdf = Pdf::loadView('admin.reportes.pdf_asistencia', compact('asistencias', 'fechaHoy'))
                  ->setPaper('a4', 'portrait');

        // 3. Retornar el PDF para previsualizar en el navegador
        return $pdf->stream("asistencia_{$fechaHoy}.pdf");
    }
}
