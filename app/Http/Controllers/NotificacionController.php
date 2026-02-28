<?php

namespace App\Http\Controllers;

use App\Models\Actividad; // Asegúrate de tener el modelo Actividad
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        // Traemos las actividades con su usuario, paginadas de 15 en 15
        $actividades = Actividad::with('user')
            ->latest()
            ->paginate(15);
        $conteo = \App\Models\Actividad::where('created_at', '>=', now()->subDay())->count();
        return view('admin.notificaciones', compact('actividades', 'conteo'));
    }

    // Opcional: Marcar actividades como leídas si añades un campo 'leido'
    public function marcarComoLeidas()
    {
        Actividad::where('leido', false)->update(['leido' => true]);
        return back()->with('success', 'Notificaciones marcadas como leídas');
    }
}
