<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class usuarios extends Model
{
    use HasFactory;

    // Estos son los campos que se pueden llenar desde un formulario
    protected $fillable = [
        'cedula',
        'nombre_apellido',
        'tipo_trabajador',
        'seccion',
        'status' // Campo nuevo para el estado del usuarios
    ];

    // Un usuarios puede tener muchos registros de asistencia
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function ultimaAsistencia(): HasOne
    {
        // Esta relación busca el registro de hoy
        return $this->hasOne(Asistencia::class)->where('fecha', now()->format('Y-m-d'));
    }

    public function show($id)
{
    // Al haber añadido el "use App\Models\usuarios" arriba, esto funcionará:
   $usuarios = usuarios::with('ultimaAsistencia')->findOrFail($id);
    return view('admin.usuarios.show', compact('usuarios'));
}
}
