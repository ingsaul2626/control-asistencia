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
    $totalEmpleados = \App\Models\User::where('role', 'user')->count();
    $asistenciasHoy = \App\Models\Asistencia::whereDate('fecha', $hoy)->get();
    $misEventos = \App\Models\Evento::where('user_id', auth()->id())->get();

    $conteoPresentes = $asistenciasHoy->whereIn('status', ['presente', 'en_progreso', 'finalizado'])->count();
    $conteoAusentes = $asistenciasHoy->where('status', 'ausente')->count();

    $idConRegistro = $asistenciasHoy->pluck('user_id');
    $conteoPendientes = \App\Models\User::where('role', 'user')
                        ->whereNotIn('id', $idConRegistro)
                        ->count();

    $porcentajeAsistencias = $totalEmpleados > 0 ? round(($conteoPresentes / $totalEmpleados) * 100) : 0;
    $empleadosAusentes = \App\Models\User::whereIn('id', $asistenciasHoy->where('status', 'ausente')->pluck('user_id'))->get();

    $reportesRecientes = \App\Models\Evento::with('user')
        ->whereNotNull('reporte_trabajador')->where('reporte_trabajador', '<>', '')
        ->orderBy('updated_at', 'desc')->take(10)->get();

    // NOTA: Aquí quitamos $todosLosEventos porque el inicio no es para asignar proyectos
    return view('dashboard', compact(
        'totalEmpleados', 'conteoPresentes', 'conteoAusentes', 'conteoPendientes',
        'porcentajeAsistencias', 'empleadosAusentes', 'reportesRecientes'
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

    // ... (Mantén tu método index igual para el Inicio)

/**
 * Método exclusivo para el Panel de Control
 * Evita la duplicidad de contenido con el Inicio
 */
public function panelControl()
{
    // Cargamos los datos para la tabla
    $eventos = \App\Models\Evento::with('user')->get();
    $usuarios = \App\Models\User::where('role', 'user')->get();

    // MODIFICACIÓN: Apunta a la carpeta proyectos y al archivo index
    return view('admin.proyectos.index', compact('eventos', 'usuarios'));
}

public function show($id)
{
    // Buscamos el proyecto con su responsable
    $evento = \App\Models\Evento::with('user')->findOrFail($id);

    // Retornamos la nueva vista que acabamos de crear
    return view('admin.proyectos.show', compact('evento'));
}
public function asignarProyecto(Request $request)
{
    // 1. Validamos los datos
    $request->validate([
        'evento_id' => 'required|exists:eventos,id',
        'user_id' => 'required|exists:users,id',
        'archivo' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048'
    ]);

    // 2. Buscamos el proyecto
    $evento = Evento::findOrFail($request->evento_id);

    // 3. Subimos el archivo si existe
    if ($request->hasFile('archivo')) {
        $ruta = $request->file('archivo')->store('planos', 'public');
        $evento->archivo_ruta = $ruta; // Asegúrate de tener esta columna en tu DB
    }

    // 4. Asignamos el trabajador y activamos el proyecto
    $evento->user_id = $request->user_id;
    $evento->activo = true;
    $evento->save();

    return redirect()->back()->with('success', '¡Proyecto vinculado y asignado con éxito!');
}
}
