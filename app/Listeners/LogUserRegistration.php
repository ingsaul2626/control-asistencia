<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Bitacora;
use App\Models\Actividad;

class LogUserRegistration
{
    public function handle(UserRegistered $event): void
    {
        // Recuperamos el usuario del evento
        $user = $event->user;

        // Insertar en Bitácora
        Bitacora::create([
            'user_id'  => $user->id,
            'accion'   => 'Registro',
            'detalles' => "Usuario {$user->name} registrado desde la web.",
            'ip'       => request()->ip(),
        ]);

        // Insertar en Actividades (Notificación)
        Actividad::create([
            'user_id'  => $user->id,
            'leido'    => 0,
            'accion'   => 'Bienvenida',
            'tipo'     => 'notificacion',
            'modelo'   => 'User',
            'detalles' => '¡Bienvenido al sistema RegistryCore!',
        ]);
    }
}
