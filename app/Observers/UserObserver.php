<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        Bitacora::create([
            // Si el admin lo crea, usamos su ID; si es autoregistro, el ID del nuevo usuario
            'user_id'  => Auth::id() ?? $user->id,
            'accion'   => 'Creación',
            'detalles' => "Se registró al usuario: {$user->name}",
            'ip'       => request()->ip(),
        ]);
    }

    public function updated(User $user): void
    {
        $cambios = $user->getChanges();

        // Seguridad: No registrar cambios sensibles ni automáticos
        unset($cambios['updated_at'], $cambios['password'], $cambios['remember_token']);

        if (count($cambios) > 0) {
            Bitacora::create([
                // CAMBIO CLAVE: Nunca usar 0. Si no hay sesión (Reset Password),
                // atribuimos el cambio al usuario mismo.
                'user_id'  => Auth::id() ?? $user->id,
                'accion'   => 'Edición',
                'detalles' => "Editado usuario ID: {$user->id} ({$user->name}). Cambios: " . json_encode($cambios),
                'ip'       => request()->ip(),
            ]);
        }
    }

    public function deleted(User $user): void
    {
        Bitacora::create([
            // Si el admin lo borra, usamos su ID; si no, el del usuario (antes de que desaparezca)
            'user_id'  => Auth::id() ?? $user->id,
            'accion'   => 'Eliminación',
            'detalles' => "Se eliminó al usuario: {$user->name} (Cédula: {$user->cedula})",
            'ip'       => request()->ip(),
        ]);
    }
}
