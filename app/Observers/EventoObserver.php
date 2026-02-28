<?php

namespace App\Observers;

use App\Models\Evento;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class EventoObserver
{
    // app/Observers/EventoObserver.php

// app/Observers/EventoObserver.php

public function created(Evento $evento)
{
    \App\Models\Actividad::create([
        'user_id' => auth()->id(),
        'accion'  => 'Creó un nuevo proyecto: ' . $evento->titulo,
        'tipo'    => 'proyecto',
        'modelo'  => 'Evento',
        'detalles' => 'Se ha registrado un nuevo evento en el sistema.', // <-- AÑADE ESTO
    ]);
}

    public function deleted(Evento $evento)
    {
        $this->registrar('Eliminación', "Eliminó el evento: {$evento->titulo}");
    }

    private function registrar($accion, $detalles)
    {
        Actividad::create([
            'user_id' => Auth::id(),
            'accion' => $accion,
            'modelo' => 'Evento',
            'detalles' => $detalles,
            'ip' => request()->ip(),
        ]);
    }
}
