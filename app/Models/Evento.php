<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
    'titulo',
    'descripcion',
    'user_id',
    'fecha',
    'archivo',
    'imagen',
    'reporte_trabajador',
    'tipo',
];


    public function user() {
    return $this->belongsTo(User::class, 'user_id');


}

public function trabajador()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

public function eventos()
{
    // Esto asume que en tu tabla 'eventos' tienes una columna 'user_id'
    return $this->hasMany(Evento::class);
}


}
