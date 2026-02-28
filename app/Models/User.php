<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cedula',
        'role',            // 'admin' o 'user'
        'tipo_trabajador', // ej: 'Obrero', 'Administrativo'
        'seccion',         // ej: 'Mantenimiento', 'Sistemas'
        'security_question', // Campo para la pregunta
        'security_answer',   // Campo para la respuesta
    ];

    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de tipos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- SISTEMA DE ASISTENCIA ---

    /**
     * Lógica Unificada de Estatus
     * Centraliza colores y etiquetas para Listado Maestro y Panel de Asistencias.
     */
   public function statusAsistenciaHoy()
    {
        $asistencia = $this->asistencias()->whereDate('fecha', now()->toDateString())->first();

        // 1. ESTADO: POR ASIGNAR (No hay registro en la DB)
        if (!$asistencia) {
            return (object) [
                'label'       => 'POR ASIGNAR',
                'boton'       => 'ASIGNAR HORARIO',
                'clase_boton' => 'bg-emerald-500 hover:bg-emerald-600',
                'texto'       => 'text-slate-400',
                'clase_punto' => 'bg-slate-300', // Gris tenue
                'status_db'   => 'por_asignar'
            ];
        }

        // 2. ESTADO: FALTA (Marcado como ausente)
        if ($asistencia->status === 'ausente') {
            return (object) [
                'label'       => 'FALTA',
                'boton'       => 'REVISAR',
                'clase_boton' => 'bg-red-500 hover:bg-red-600',
                'texto'       => 'text-red-600',
                'clase_punto' => 'bg-red-500', // Rojo
                'status_db'   => 'ausente'
            ];
        }

        // 3. ESTADO: EN PROGRESO (El usuario aceptó y está trabajando)
        if ($asistencia->status === 'en_progreso') {
            return (object) [
                'label'       => 'EN PROGRESO',
                'boton'       => 'ACTUALIZAR',
                'clase_boton' => 'bg-blue-600 hover:bg-blue-700',
                'texto'       => 'text-emerald-600',
                'clase_punto' => 'bg-emerald-500 animate-pulse', // Verde parpadeante
                'status_db'   => 'en_progreso'
            ];
        }

        // 4. ESTADO: FINALIZADO (Ya marcó salida o el admin lo acaba de asignar)
        if ($asistencia->status === 'finalizado' || $asistencia->status === 'presente') {

            // Sub-estado: Asignado pero no ha iniciado (hora_salida vacía y no está "en progreso")
            if (!$asistencia->hora_salida) {
                return (object) [
                    'label'       => 'ASIGNADO',
                    'boton'       => 'ACTUALIZAR',
                    'clase_boton' => 'bg-blue-600 hover:bg-blue-700',
                    'texto'       => 'text-blue-600',
                    'clase_punto' => 'bg-blue-500', // Azul fijo
                    'status_db'   => 'finalizado'
                ];
            }

            // Sub-estado: Realmente finalizado (Ya tiene hora de salida)
            return (object) [
                'label'       => 'FINALIZADO',
                'boton'       => 'ACTUALIZAR',
                'clase_boton' => 'bg-slate-700 hover:bg-slate-800',
                'texto'       => 'text-slate-700',
                'clase_punto' => 'bg-emerald-700', // Verde oscuro fijo
                'status_db'   => 'finalizado'
            ];
        }

        // Caso por defecto por seguridad
        return (object) [
            'label' => 'REVISAR',
            'boton' => 'ACTUALIZAR',
            'clase_boton' => 'bg-gray-500',
            'texto' => 'text-gray-500',
            'clase_punto' => 'bg-gray-500'
        ];
    }
    /**
     * Obtiene todo el historial de asistencias del trabajador.
     */
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'user_id');
    }

    /**
     * Obtiene el registro de asistencia del día de hoy.
     */
    public function asistenciaHoy(): HasOne
    {
        return $this->hasOne(Asistencia::class, 'user_id')
                    ->where('fecha', now()->toDateString());
    }

    /**
     * Alias de la última asistencia.
     */
    public function ultimaAsistencia(): HasOne
    {
        return $this->hasOne(Asistencia::class, 'user_id')->latestOfMany('fecha');
    }

    // --- AYUDANTES DE ROL ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin() {
    return $this->role === 'super_admin';
}
}
