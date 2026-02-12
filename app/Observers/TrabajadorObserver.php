<?php

namespace App\Observers;

use App\Models\Trabajador;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class TrabajadorObserver
{
    // Se ejecuta tras CREAR un registro
    public function created(Trabajador $trabajador): void
    {
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'Creación',
            'detalles' => "Se registró al trabajador: {$trabajador->nombre}",
            'ip' => request()->ip(),
        ]);
    }

    // Se ejecuta tras EDITAR un registro
    public function updated(Trabajador $trabajador): void
    {
        // Obtenemos qué campos cambiaron
        $cambios = $trabajador->getChanges();
        unset($cambios['updated_at']); // No nos interesa rastrear la fecha de actualización

        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'Edición',
            'detalles' => "Se editó al trabajador {$trabajador->nombre}. Cambios: " . json_encode($cambios),
            'ip' => request()->ip(),
        ]);
    }

    // Se ejecuta tras ELIMINAR un registro
    public function deleted(Trabajador $trabajador): void
    {
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'Eliminación',
            'detalles' => "Se eliminó el registro del trabajador: {$trabajador->nombre}",
            'ip' => request()->ip(),
        ]);
    }
}
