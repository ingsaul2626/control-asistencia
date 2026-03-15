<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

 public function index()
{
    $hoy = now()->toDateString();

    // 1. Estadísticas básicas
    $totalUsuarios = \App\Models\User::where('role', 'user')->count();
    $asistenciasHoy = \App\Models\Asistencia::whereDate('fecha', $hoy)->get();

    // 2. Conteo de Estados
    $conteoPresentes = $asistenciasHoy->whereIn('status', ['presente', 'en_progreso', 'finalizado'])->count();
    $conteoAusentes = $asistenciasHoy->where('status', 'ausente')->count();

    // 3. Cálculo de Pendientes: Usuarios 'user' que no tienen NINGÚN registro hoy
    $idsConCualquierRegistro = $asistenciasHoy->pluck('user_id');
    $usuariosPendientes = \App\Models\User::where('role', 'user')
                            ->whereNotIn('id', $idsConCualquierRegistro)
                            ->get();
    $conteoPendientes = $usuariosPendientes->count();

    // 4. Lista específica de Usuarios Ausentes (los que tienen el status 'ausente' en la tabla asistencias)
    $usuariosAusentes = \App\Models\User::whereIn('id',
        $asistenciasHoy->where('status', 'ausente')->pluck('user_id')
    )->get();

    // 5. Porcentaje (evitando división por cero)
    $porcentajeAsistencias = $totalUsuarios > 0
        ? round(($conteoPresentes / $totalUsuarios) * 100)
        : 0;

    // 6. Proyectos recientes
    $proyectos = \App\Models\Proyecto::query()
        ->whereNotNull('user_id')
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();

    return view('dashboard', compact(
        'totalUsuarios',
        'conteoPresentes',
        'conteoAusentes',
        'conteoPendientes',
        'porcentajeAsistencias',
        'usuariosAusentes',
        'usuariosPendientes',
        'proyectos'
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

        $evento = Proyecto::findOrFail($request->evento_id);
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

        $proyecto = new Proyecto();
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
        $proyecto = Proyecto::findOrFail($id);
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
        $proyecto = Proyecto::findOrFail($id);
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
    $proyectos = \App\Models\Proyecto::with('user')->get();
    $usuarios = \App\Models\User::where('role', 'user')->get();


    return view('admin.panel', compact('proyectos', 'usuarios'));
}

public function show($id)
{
    // Buscamos el proyecto con su responsable
    $proyecto = \App\Models\Proyecto::with('user')->findOrFail($id);

    // Retornamos la nueva vista que acabamos de crear
    return view('admin.proyectos.show', compact('proyecto'));
}
public function asignarProyecto(Request $request)
{
    // 1. Validamos los datos
    $request->validate([
        'evento_id' => 'required|exists:proyectos,id',
        'user_id' => 'required|exists:users,id',
        'archivo' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048'
    ]);

    // 2. Buscamos el proyecto
    $proyecto = Proyecto::findOrFail($request->evento_id);

    // 3. Subimos el archivo si existe
    if ($request->hasFile('archivo')) {
        $ruta = $request->file('archivo')->store('planos', 'public');
        $proyecto->archivo_ruta = $ruta; // Asegúrate de tener esta columna en tu DB
    }

    // 4. Asignamos el trabajador y activamos el proyecto
    $proyecto->user_id = $request->user_id;
    $proyecto->activo = true;
    $proyecto->save();

    return redirect()->back()->with('success', '¡Proyecto vinculado y asignado con éxito!');
}


public function aprobarUsuario(Request $request, $id)
{
    $usuario = \App\Models\User::findOrFail($id);

    // Cambiamos el estado a aprobado
    $usuario->update([
        'is_approval' => true,
        'status' => 'active' // Opcional: si también controlas el estatus por texto
    ]);

    return back()->with('success', 'Usuario aprobado exitosamente.');
}

public function rechazarUsuario(Request $request, $id)
{
    $usuario = \App\Models\User::findOrFail($id);
    // Puedes eliminarlo o simplemente marcarlo como denegado
    $usuario->delete();

    return back()->with('success', 'Usuario rechazado.');
}
}
