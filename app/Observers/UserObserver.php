<?php

namespace App\Observers;

use App\Models\User; // Cambiado de Trabajador a User
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class TrabajadorObserver
{
    // Se ejecuta tras CREAR un registro
    public function created(User $user): void
    {
        Bitacora::create([
            'user_id'  => Auth::id(),
            'accion'   => 'Creación',
            'detalles' => "Se registró al usuario: {$user->name}", // Ajusta 'nombre' si tu columna es 'name'
            'ip'       => request()->ip(),
        ]);
    }

    // Se ejecuta tras EDITAR un registro
    public function updated(User $user): void
    {
        $cambios = $user->getChanges();
        unset($cambios['updated_at'], $cambios['password']); // Buena práctica: nunca guardar la contraseña en la bitácora

        Bitacora::create([
            'user_id'  => Auth::id(),
            'accion'   => 'Edición',
            'detalles' => "Se editó al usuario {$user->name}. Cambios: " . json_encode($cambios),
            'ip'       => request()->ip(),
        ]);
    }

    // Se ejecuta tras ELIMINAR un registro
    public function deleted(User $user): void
    {
        Bitacora::create([
            'user_id'  => Auth::id(),
            'accion'   => 'Eliminación',
            'detalles' => "Se eliminó el registro del usuario: {$user->name}",
            'ip'       => request()->ip(),
        ]);
    }
}
