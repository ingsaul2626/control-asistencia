<?php

namespace App\Observers;

use App\Models\Proyecto;

class ProyectoObserver
{
    /**
     * Handle the Proyecto "created" event.
     */
    public function created(Proyecto $proyecto): void
    {
        //
    }

    /**
     * Handle the Proyecto "updated" event.
     */
    public function updated(Proyecto $proyecto): void
    {
        //
    }

    /**
     * Handle the Proyecto "deleted" event.
     */
    public function deleted(Proyecto $proyecto) {
    Bitacora::create([
        'user_id' => auth()->id(),
        'accion' => 'Eliminación',
        'modelo' => 'Proyecto',
        'detalles' => "Se eliminó el proyecto: " . $proyecto->nombre,
        'ip_address' => request()->ip(), // Registra la IP que usaste en el túnel
    ]);
}

    /**
     * Handle the Proyecto "restored" event.
     */
    public function restored(Proyecto $proyecto): void
    {
        //
    }

    /**
     * Handle the Proyecto "force deleted" event.
     */
    public function forceDeleted(Proyecto $proyecto): void
    {
        //
    }
}
