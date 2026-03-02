<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    // Actualizado con todos los campos necesarios para notificaciones y bitácora
    protected $fillable = [
        'user_id',
        'titulo',
        'mensaje',
        'leido',
        'accion',
        'tipo',
        'modelo',
        'detalles'
    ];

    /**
     * Relación: Una actividad pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
