<?php

namespace App\Observers;

use App\Models\Proyecto;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class ProyectoObserver
{
    public function created(Proyecto $proyecto): void
{
    // Supongamos que el proyecto tiene un 'user_id' asignado
    if ($proyecto->user_id) {
        \App\Models\Actividad::create([
            'user_id'  => $proyecto->user_id,
            'leido'    => 0,
            'accion'   => 'Proyecto',
            'tipo'     => 'notificacion',
            'modelo'   => 'Proyecto',
            'detalles' => "Se te ha asignado un nuevo proyecto: {$proyecto->nombre}",
        ]);
    }
}
    public function updated(Proyecto $proyecto): void
{

    if ($proyecto->wasChanged() && $proyecto->user_id !== Auth::id()) {
        Actividad::create([
            'user_id'  => $proyecto->user_id,
            'leido'    => 0,
            'accion'   => 'Actualización',
            'tipo'     => 'notificacion',
            'modelo'   => 'Proyecto',
            'detalles' => "Tu proyecto '{$proyecto->nombre}' ha sido actualizado por un administrador.",
        ]);
    }
}


    public function deleted(Proyecto $proyecto)
    {
        $this->registrar('Eliminación', "Eliminó el proyecto: {$proyecto->titulo}");
    }

    private function registrar($accion, $detalles)
    {
        Actividad::create([
            'user_id'  => Auth::id(),
            'accion'   => $accion,
            'tipo'     => 'proyecto',
            'modelo'   => 'Proyecto',
            'detalles' => $detalles,
            'ip'       => request()->ip(),
        ]);
    }
}
