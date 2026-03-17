<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Vista para el Administrador (Bitácora completa)
     */
    public function index()
    {
        // MEJORA: El admin ve todo, pero filtramos para que NO vea sus propias acciones
        // Así la campana del admin no se llena con "Admin actualizó proyecto"
        $actividades  = Actividad::where('user_id', Auth::id())
            ->where('user_id', '!=', Auth::id()) // Solo si quieres que el admin vea lo de otros
            ->latest()
            ->take(10)
            ->get();

        // El conteo también debe ignorar las acciones del propio admin
        $conteo = Actividad::where('leido', false)
            ->where('user_id', '!=', Auth::id()) // <--- Filtro clave
            ->count();

        return view('admin.notificaciones', compact('actividades', 'conteo'));
    }

    /**
     * Vista para los usuarios (Sus proyectos y asistencias)
     */
    public function misNotificaciones()
    {
        // Aquí está perfecto como lo tenías
        $actividades = Actividad::where('user_id', Auth::id())->latest()->paginate(15);

        $conteo = Actividad::where('user_id', Auth::id())
            ->where('leido', false)
            ->count();

        return view('user.notificaciones', compact('actividades', 'conteo'));
    }

    /**
     * Marca como leídas y regresa
     */
    public function marcarComoLeidas()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        // El admin limpia lo de los demás (lo que ve en su campana)
        Actividad::where('user_id', Auth::id())->update(['leido' => 1]);


    } else {
        // El usuario normal limpia lo suyo
        Actividad::where('user_id', $user->id)
            ->where('leido', false)
            ->update(['leido' => true]);
    }

    return back()->with('success', 'Notificaciones actualizadas');
}
    /**
     * Marca una sola y regresa
     */
    public function marcarUnaLeida($id)
    {
        // Seguridad: Solo puede marcar sus propias notificaciones
        $notificacion = Actividad::where('user_id', Auth::id())->findOrFail($id);
        $notificacion->update(['leido' => true]);

        return back();
    }
}
