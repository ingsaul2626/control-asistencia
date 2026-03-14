<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'hora_entrada_admin',
        'hora_entrada_real',
        'hora_salida',
        'fecha',
        'observaciones'
    ];
        protected $casts = [
        'fecha' => 'date',
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];
    /**
     * Relación principal con el modelo User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación de compatibilidad (Mapea 'usuarios' a 'user').
     */
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accesor para calcular horas trabajadas.
     */
    public function getHorasTrabajadasAttribute()
{
    if ($this->hora_entrada && $this->hora_salida) {
        $entrada = \Carbon\Carbon::parse($this->hora_entrada);
        $salida = \Carbon\Carbon::parse($this->hora_salida);
        // Retorna la diferencia en horas con dos decimales
        return round($entrada->diffInMinutes($salida) / 60, 2);
    }
    return 0;
}



}
