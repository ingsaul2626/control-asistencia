<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // Mantenemos la tabla original para no romper la base de datos
    protected $table = 'proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'user_id',
        'fecha',
        'fecha_inicio',
        'fecha_entrega',
        'archivo',
        'imagen',
        'reporte_trabajador',
        'tipo',
        'activo', 
        'visible'
    ];

    /**
     * Relación con el usuario responsable del proyecto.
     * Nombre claro y único.
     */
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


}
