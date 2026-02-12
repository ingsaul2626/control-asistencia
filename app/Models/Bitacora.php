<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opcional pero recomendado
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'bitacoras';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'accion',
        'detalles',
        'ip'
    ];

    /**
     * Relación: Una bitácora pertenece a un usuario.
     * Esto permite hacer $bitacora->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} // <--- Asegúrate de que esta llave cierre la clase
