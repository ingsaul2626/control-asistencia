<?php

namespace App\Observers;

use App\Models\Proyecto;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class ProyectoObserver
{
    public function created(Proyecto $proyecto)
    {
        $this->registrar('Creación', "Creó un nuevo proyecto: {$proyecto->titulo}");
    }

    public function updated(Proyecto $proyecto)
    {
        $this->registrar('Actualización', "Actualizó el proyecto: {$proyecto->titulo}");
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
