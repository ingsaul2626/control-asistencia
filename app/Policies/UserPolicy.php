<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function manage(User $authenticated, User $target)
{
    // Nadie puede borrar al ID 1
    if ($target->id == 1) {
        return false;
    }
    return $authenticated->role === 'admin';
}
}
