<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class UserObserver // Cambia el nombre a UserObserver
{
    public function created(User $user): void
    {
        Bitacora::create([

            'user_id'  => Auth::id() ?? $user->id,
            'accion'   => 'Creación',
            'detalles' => "Se registró al usuario: {$user->name}",
            'ip'       => request()->ip(),
        ]);

    }

    public function updated(User $user): void
    {
        // Obtenemos solo lo que cambió
        $cambios = $user->getChanges();

        // Quitamos datos que no queremos ver en la bitácora (seguridad)
        unset($cambios['updated_at'], $cambios['password']);

        if (count($cambios) > 0) {
            Bitacora::create([
                'user_id'  => Auth::id() ?? 0, // ID del administrador que editó
                'accion'   => 'Edición',
                'detalles' => "Editado usuario ID: {$user->id} ({$user->name}). Cambios: " . json_encode($cambios),
                'ip'       => request()->ip(),
            ]);
        }
    }

    public function deleted(User $user): void
{
    Bitacora::create([
        'user_id'  => Auth::id() ?? $user->id,
        'accion'   => 'Eliminación',
        'detalles' => "Se eliminó al usuario: {$user->name} (Cédula: {$user->cedula})",
        'ip'       => request()->ip(),
    ]);
}

}
