<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    // Añade estas líneas:
protected $fillable = ['user_id', 'accion', 'tipo', 'modelo', 'detalles'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
