<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function dashboard()
    {
        $todosLosEventos = Evento::all();
        $todosLosUsuarios = User::where('role', 'user')->get();

        return view('admin.dashboard', compact('todosLosEventos', 'todosLosUsuarios'));
    }

    public function index()
    {
        $eventos = Evento::with('user')->latest()->get();
        $usuarios = User::where('role', 'user')->get();

        return view('eventos.index', compact('eventos', 'usuarios'));
    }

    public function store(Request $request)
{
    // 1. Validación estricta
    $request->validate([
        'titulo'  => 'required|string|max:255',
        'user_id' => 'required|exists:users,id',
        'fecha'   => 'required|date',
        'tipo'    => 'required|string', // Campo obligatorio según tu error previo
        'lugar'   => 'nullable|string|max:255',
        'imagen'  => 'required|image|max:2048',
        'archivo' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    // 2. Procesamiento de archivos
    $rutaImagen = $request->file('imagen')->store('proyectos', 'public');

    $rutaPdf = null;
    if ($request->hasFile('archivo')) {
        $rutaPdf = $request->file('archivo')->store('documentos', 'public');
    }

    // 3. ÚNICA creación del registro
    Evento::create([
        'titulo'      => $request->titulo,
        'descripcion' => $request->descripcion,
        'imagen'      => $rutaImagen,
        'archivo'     => $rutaPdf,
        'user_id'     => $request->user_id,
        'fecha'       => $request->fecha,
        'tipo'        => $request->tipo,
        'lugar'       => $request->lugar,
    ]);

    return redirect()->back()->with('success', 'Proyecto publicado y asignado correctamente.');
}

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);


        // Opcional: Eliminar archivos físicos del storage para no llenar el disco
        if($evento->imagen) Storage::disk('public')->delete($evento->imagen);
        if($evento->archivo) Storage::disk('public')->delete($evento->archivo);

        $evento->delete();

        return redirect()->back()->with('success', 'Proyecto eliminado correctamente');
    }

    public function asignar(Request $request)
    {
        $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'user_id'   => 'required|exists:users,id',
            'archivo'   => 'nullable|mimes:pdf|max:10240',
        ]);

        $proyecto = Evento::findOrFail($request->evento_id);

        $proyecto->user_id = $request->user_id;
        $proyecto->fecha = now();

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('planos', 'public');
            $proyecto->archivo = $path;
        }

        $proyecto->save();

        return back()->with('success', '¡Proyecto actualizado con éxito!');
    }

public function edit($id)
{
    $proyecto = Evento::findOrFail($id);
    $usuarios = User::where('role', 'user')->get();

    // El nombre de la vista debe coincidir con la carpeta
    return view('admin.proyectos.edit', compact('proyecto', 'usuarios'));
}

// 2. Procesar la actualización de los datos
public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'user_id' => 'required|exists:users,id',
        'imagen' => 'nullable|image|max:2048',
        'archivo' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    $proyecto = Evento::findOrFail($id);

    // Actualizar imagen solo si se subió una nueva
    if ($request->hasFile('imagen')) {
        $rutaImagen = $request->file('imagen')->store('proyectos', 'public');
        $proyecto->imagen = $rutaImagen;
    }

    // Actualizar archivo solo si se subió uno nuevo
    if ($request->hasFile('archivo')) {
        $rutaPdf = $request->file('archivo')->store('planos', 'public');
        $proyecto->archivo = $rutaPdf;
    }

    $proyecto->titulo = $request->titulo;
    $proyecto->descripcion = $request->descripcion;
    $proyecto->user_id = $request->user_id;
    $proyecto->fecha = $request->fecha;

    $proyecto->save();

    return redirect()->route('admin.dashboard')->with('success', 'Proyecto actualizado con éxito');
}
public function show($id )
{


    if ($id === 'index') {
        return redirect()->route('admin.proyectos.index');
    }
    $evento = \App\Models\Evento::with('user')->findOrFail($id);
    $proyecto = Evento::findOrFail($id);
    return view('admin.proyectos.show', compact('proyecto'));
    return view('admin.proyectos.show', compact('evento'));
}

public function reportes()
{
    // Buscamos los eventos que tengan algo escrito en 'reporte_trabajador'
    $reportes = Evento::whereNotNull('reporte_trabajador')
                      ->where('reporte_trabajador', '!=', '')
                      ->with('user')
                      ->get();

    return view('admin.proyectos.reportes', compact('reportes'));
}
public function finalizados()
{
    // Filtramos los que tienen activo = 0
    $eventosCulminados = \App\Models\Evento::where('activo', 0)
        ->with('user')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('admin.proyectos.finalizados', compact('eventosCulminados'));
}


}

