<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Vista para el Administrador (Bitácora completa)
     */
    public function index()
    {
        $actividades = Actividad::with('user')->latest()->paginate(15);

        // El admin cuenta lo global
        $conteo = Actividad::where('leido', false)->count();

        return view('admin.notificaciones', compact('actividades', 'conteo'));
    }

    /**
     * Vista para el usuarios (Sus proyectos asignados)
     */
    public function misNotificaciones()
    {
        $actividades = Actividad::where('user_id', Auth::id())->latest()->paginate(15);

        // Saúl solo cuenta las suyas
        $conteo = Actividad::where('user_id', Auth::id())
            ->where('leido', false)
            ->count();

        return view('user.notificaciones', compact('actividades', 'conteo'));
    }

    /**
     * Marca como leídas y REDIRECCIONA (Para que el botón del Navbar funcione)
     */
    public function marcarComoLeidas()
    {
        $users = Auth::user();

        if ($users->role === 'admin') {
            // Si el admin limpia, marca TODO como leido (opcional, según tu lógica)
            Actividad::where('leido', false)->update(['leido' => true]);
        } else {
            // El usuarios marca solo lo suyo
            Actividad::where('user_id', $users->id)
                ->where('leido', false)
                ->update(['leido' => true]);
        }

        // CAMBIO CLAVE: Usar back() en lugar de response()->json()
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
