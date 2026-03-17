<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;


    protected $fillable = [
        'name', 'email', 'password', 'cedula', 'role',
        'tipo_trabajador', 'seccion', 'telefono', 'cargo',
        'security_question', 'security_answer', 'status','is_approved','seccion', 'remember_token',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'status' => 'string',
            'role' => 'string',
            'tipo_trabajador' => 'string',
            'seccion' => 'string',
            'cargo' => 'string',
            'security_question' => 'string',
            'security_answer' => 'string',
            'remember_token' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // --- LÓGICA DE MOSTRAR (Agregado desde tu modelo antiguo) ---

    /**
     * Nota: Normalmente este método iría en el Controlador,
     * pero aquí tienes la lógica adaptada para tu modelo.
     */
    public static function obtenerUsuarioConAsistencia($id)
    {
        return self::with('ultimaAsistencia')->findOrFail($id);
    }

    // --- SISTEMA DE ASISTENCIA ---

    public function statusAsistenciaHoy()
    {
        $asistencia = $this->asistencias()->whereDate('fecha', now()->toDateString())->first();

        if (!$asistencia) {
            return (object) [
                'label' => 'POR ASIGNAR', 'boton' => 'ASIGNAR HORARIO',
                'clase_boton' => 'bg-emerald-500 hover:bg-emerald-600',
                'texto' => 'text-slate-400', 'clase_punto' => 'bg-slate-300', 'status_db' => 'por_asignar'
            ];
        }

        if ($asistencia->status === 'ausente') {
            return (object) [
                'label' => 'FALTA', 'boton' => 'REVISAR',
                'clase_boton' => 'bg-red-500 hover:bg-red-600',
                'texto' => 'text-red-600', 'clase_punto' => 'bg-red-500', 'status_db' => 'ausente'
            ];
        }

        if ($asistencia->status === 'en_progreso') {
            return (object) [
                'label' => 'EN PROGRESO', 'boton' => 'ACTUALIZAR',
                'clase_boton' => 'bg-blue-600 hover:bg-blue-700',
                'texto' => 'text-emerald-600', 'clase_punto' => 'bg-emerald-500 animate-pulse', 'status_db' => 'en_progreso'
            ];
        }

        if ($asistencia->status === 'finalizado' || $asistencia->status === 'presente') {
            if (!$asistencia->hora_salida) {
                return (object) [
                    'label' => 'ASIGNADO', 'boton' => 'ACTUALIZAR',
                    'clase_boton' => 'bg-blue-600 hover:bg-blue-700',
                    'texto' => 'text-blue-600', 'clase_punto' => 'bg-blue-500', 'status_db' => 'finalizado'
                ];
            }
            return (object) [
                'label' => 'FINALIZADO', 'boton' => 'ACTUALIZAR',
                'clase_boton' => 'bg-slate-700 hover:bg-slate-800',
                'texto' => 'text-slate-700', 'clase_punto' => 'bg-emerald-700', 'status_db' => 'finalizado'
            ];
        }

        return (object) ['label' => 'REVISAR', 'boton' => 'ACTUALIZAR', 'clase_boton' => 'bg-gray-500', 'texto' => 'text-gray-500', 'clase_punto' => 'bg-gray-500'];
    }

    // --- RELACIONES ---

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'user_id');
    }

    public function asistenciaHoy(): HasOne
    {
        return $this->hasOne(Asistencia::class, 'user_id')
                    ->where('fecha', now()->toDateString());
    }

    public function ultimaAsistencia(): HasOne
    {
        return $this->hasOne(Asistencia::class, 'user_id')->latestOfMany('fecha');
    }

    public function actividades(): HasMany
    {
        return $this->hasMany(Actividad::class);
    }

    // --- AYUDANTES DE ROL ---

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->role === 'super_admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isOperator() {
    return $this->role === 'operador';
    }



    //is_approved es un booleano que indica si el usuario ha sido aprobado por un admin
  public function getStatusAttribute()
{
    // Usamos is_approved porque es la columna real en tu tabla
    return $this->is_approved ? 'APROBADO' : 'PENDIENTE';
}

public function redirectPath()
{
    // Usamos Auth::user() que es lo estándar en Laravel
    $user = Auth::user();

    if ($user && $user->is_approved && $user->status === 'APROBADO') {
        return '/dashboard';
    }

    // En lugar de cerrar sesión aquí (que puede causar bucles),
    // es mejor manejar la redirección y que el middleware se encargue del resto.
    return '/login?error=no_aprobado';
}





}
