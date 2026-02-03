<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\User;
use App\Models\Asistencia; // Asegúrate de importar el modelo
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
   public function index()
{
    $hoy = now()->toDateString();

    // 1. ESTADÍSTICAS DE ASISTENCIA (NUEVA LÓGICA)
    // Usamos el conteo de usuarios con rol 'user' como base de la plantilla
    $totalEmpleados = \App\Models\User::where('role', 'user')->count();

    $asistenciasHoy = \App\Models\Asistencia::whereDate('fecha', $hoy)->get();

    // Presentes: estados que indican actividad (presente, en_progreso, finalizado)
    $conteoPresentes = $asistenciasHoy->whereIn('status', ['presente', 'en_progreso', 'finalizado'])->count();

    // Ausentes: marcados explícitamente como ausentes
    $conteoAusentes = $asistenciasHoy->where('status', 'ausente')->count();

    // Pendientes: Usuarios que no tienen ningún registro en la tabla de asistencias hoy
    $idConRegistro = $asistenciasHoy->pluck('user_id');
    $conteoPendientes = \App\Models\User::where('role', 'user')
                        ->whereNotIn('id', $idConRegistro)
                        ->count();

    $porcentajeAsistencias = $totalEmpleados > 0 ? round(($conteoPresentes / $totalEmpleados) * 100) : 0;

    // 2. LISTA DE AUSENTES (Para la tabla lateral)
    $empleadosAusentes = \App\Models\User::whereIn('id', $asistenciasHoy->where('status', 'ausente')->pluck('user_id'))->get();

    // 3. PROYECTOS Y REPORTES (TU INFO ORIGINAL)
    $reportesRecientes = \App\Models\Evento::with('user')
        ->whereNotNull('reporte_trabajador')
        ->where('reporte_trabajador', '<>', '')
        ->orderBy('updated_at', 'desc')
        ->take(10)->get();

    $todosLosEventos = \App\Models\Evento::all();
    $todosLosUsuarios = \App\Models\User::where('role', 'user')->get();

    return view('dashboard', compact(
        'totalEmpleados', 'conteoPresentes', 'conteoAusentes', 'conteoPendientes',
        'porcentajeAsistencias', 'empleadosAusentes', 'reportesRecientes',
        'todosLosEventos', 'todosLosUsuarios'
    ));
}
    // --- MANTENEMOS TUS FUNCIONES DE PROYECTOS INTACTAS ---

    public function assignWorker(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,zip,docx,jpg,png|max:10240',
        ]);

        $evento = Evento::findOrFail($request->evento_id);
        $evento->user_id = $request->user_id;
        $evento->descripcion = $request->descripcion;

        if ($request->hasFile('archivo')) {
            $evento->archivo = $request->file('archivo')->store('documentos', 'public');
        }

        $evento->save();
        return back()->with('success', '¡Proyecto asignado con éxito!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'archivo' => 'nullable|file|mimes:pdf,zip,docx,jpg,png|max:10240',
        ]);

        $proyecto = new Evento();
        $proyecto->titulo = $request->titulo;
        $proyecto->user_id = $request->user_id;
        $proyecto->fecha = now()->format('Y-m-d');

        if ($request->hasFile('archivo')) {
            $proyecto->archivo = $request->file('archivo')->store('documentos', 'public');
        }

        $proyecto->save();
        return back()->with('success', 'Nuevo proyecto creado.');
    }

    public function update(Request $request, $id)
    {
        $proyecto = Evento::findOrFail($id);
        $proyecto->titulo = $request->titulo;
        $proyecto->user_id = $request->user_id;
        $proyecto->fecha = $request->fecha ?? $proyecto->fecha;

        if ($request->hasFile('archivo')) {
            $proyecto->archivo = $request->file('archivo')->store('documentos', 'public');
        }

        $proyecto->save();
        return redirect()->route('admin.dashboard')->with('success', 'Proyecto actualizado.');
    }

    public function destroy($id)
    {
        $proyecto = Evento::findOrFail($id);
        if ($proyecto->archivo) {
            Storage::disk('public')->delete($proyecto->archivo);
        }
        $proyecto->delete();
        return back()->with('success', 'Proyecto eliminado.');
    }
}
