<?php

namespace App\Observers;

use App\Models\Asistencia;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class AsistenciaObserver
{
    /**
     * Se dispara cuando se registra una nueva asistencia (Entrada/Salida).
     */
    public function created(Asistencia $asistencia): void
    {
        Actividad::create([
            'user_id'  => $asistencia->user_id,
            'leido'    => 0,
            'accion'   => 'Asistencia',
            'tipo'     => 'notificacion',
            'modelo'   => 'Asistencia',
            'detalles' => "Tu asistencia ha sido registrada: " . ($asistencia->tipo ?? 'Entrada/Salida'),
        ]);
    }

    /**
     * Se dispara cuando se actualiza una asistencia (ej. el admin corrige la hora).
     */
    public function updated(Asistencia $asistencia): void
    {
        if ($asistencia->wasChanged()) {
            Actividad::create([
                'user_id'  => $asistencia->user_id,
                'leido'    => 0,
                'accion'   => 'Actualización',
                'tipo'     => 'notificacion',
                'modelo'   => 'Asistencia',
                'detalles' => "Se ha corregido la información de tu asistencia del día " . $asistencia->created_at->format('d/m/Y'),
            ]);
        }
    }

    /**
     * Handle the Asistencia "deleted" event.
     */
    public function deleted(Asistencia $asistencia): void
    {
        //
    }

    /**
     * Handle the Asistencia "restored" event.
     */
    public function restored(Asistencia $asistencia): void
    {
        //
    }

    /**
     * Handle the Asistencia "force deleted" event.
     */
    public function forceDeleted(Asistencia $asistencia): void
    {
        //
    }
}
