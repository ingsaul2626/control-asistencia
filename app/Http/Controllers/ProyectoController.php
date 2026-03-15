<?php

namespace App\Http\Controllers;

use App\Models\Proyecto; // Usamos el modelo unificado
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProyectoController extends Controller
{
    public function dashboard()
    {
        $proyectos = Proyecto::all();
        $usuarios = User::where('role', 'user')->get();

        return view('admin.dashboard', compact('proyectos', 'usuarios'));
    }

    public function index()
    {
        $proyectos = Proyecto::with('user')->latest()->get();
        $usuarios = User::where('role', 'user')->get();
        

        return view('admin.proyectos.index', compact('proyectos', 'usuarios'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'titulo'  => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'fecha_inicio' => 'required|date',
            'fecha_entrega' => 'required|date',
            'tipo'    => 'required|string',
            'imagen'  => 'required|image|max:2048',
            'archivo_pdf' => 'nullable|mimes:pdf|max:5120',
            'descripcion' => 'nullable|string',
            'reporte_trabajador',
        ]);

        $proyecto = new \App\Models\Proyecto($request->except(['imagen', 'archivo_pdf']));


        if ($request->hasFile('imagen')) {
        $proyecto->imagen = $request->file('imagen')->store('proyectos/imagenes', 'public');
    }

    // Procesar PDF
    if ($request->hasFile('archivo_pdf')) {
        $proyecto->archivo_pdf = $request->file('archivo_pdf')->store('proyectos/pdfs', 'public');
    }

    $proyecto->save();

    return redirect()->route('admin.proyectos.index')
                     ->with('success', 'Proyecto creado con éxito.');

    // 3. Procesar archivo de IMAGEN (guardar una sola vez)

    if ($request->hasFile('imagen')) {
        // Guardamos en storage/app/public/proyectos/imagenes
        $proyecto->imagen = $request->file('imagen')->store('proyectos/imagenes', 'public');
    }

    // 4. Procesar archivo PDF (guardar una sola vez)
    if ($request->hasFile('archivo_pdf')) {
        // Guardamos en storage/app/public/proyectos/pdfs
        $proyecto->archivo_pdf = $request->file('archivo_pdf')->store('proyectos/pdfs', 'public');
    }

    // 5. Guardar en la base de datos
    $proyecto->save();

    // 6. Redireccionar con éxito
    return redirect()->route('admin.proyectos.index')
                     ->with('success', 'Proyecto creado con éxito.');



        $rutaImagen = $request->file('imagen')->store('proyectos', 'public');
        $rutaPdf = $request->hasFile('archivo') ? $request->file('archivo')->store('documentos', 'public') : null;


        Proyecto::create([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen'      => $rutaImagen,
            'archivo'     => $rutaPdf,
            'user_id'     => $request->user_id,
            'fecha'       => $request->fecha,
            'tipo'        => $request->tipo,
            'lugar'       => $request->lugar,
        ]);

        return redirect()->back()->with('success', 'Proyecto creado correctamente.');
    }

    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $usuarios = User::where('role', 'user')->get();

        return view('admin.proyectos.edit', compact('proyecto', 'usuarios'));
    }

   public function update(Request $request, $id)
{
    $proyecto = Proyecto::findOrFail($id);

    // 1. Validar (Asegúrate que coincida con tus columnas reales)
    $validated = $request->validate([
        'titulo'        => 'required|string|max:255',
        'user_id'       => 'required|exists:users,id',
        'fecha_inicio'  => 'nullable|date',
        'fecha_entrega' => 'nullable|date|after_or_equal:fecha_inicio',
        'categoria'     => 'nullable|string',
        'imagen'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'archivo'       => 'nullable|file|mimes:pdf,docx,xlsx|max:5120',
    ]);

    // 2. Procesar Archivos (Si existen)
    if ($request->hasFile('imagen')) {
        if ($proyecto->imagen) Storage::disk('public')->delete($proyecto->imagen);
        $validated['imagen'] = $request->file('imagen')->store('proyectos/imagenes', 'public');
    }

    if ($request->hasFile('archivo')) {
        if ($proyecto->archivo) Storage::disk('public')->delete($proyecto->archivo);
        $validated['archivo'] = $request->file('archivo')->store('proyectos/planos', 'public');
    }

    // 3. Actualizar
    $proyecto->update($validated);

    return redirect()->route('admin.proyectos.index')->with('success', 'Proyecto actualizado con éxito.');
}

    public function show($id)
    {
        $proyecto = Proyecto::with('user')->findOrFail($id);
        return view('admin.proyectos.show', compact('proyecto'));
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if($proyecto->imagen) Storage::disk('public')->delete($proyecto->imagen);
        if($proyecto->archivo) Storage::disk('public')->delete($proyecto->archivo);
        $proyecto->delete();

        return redirect()->back()->with('success', 'Proyecto eliminado correctamente');
    }

    public function reportes()
    {
        $reportes = Proyecto::whereNotNull('reporte_trabajador')
                          ->where('reporte_trabajador', '!=', '')
                          ->with('user')
                          ->get();

        return view('admin.proyectos.reportes', compact('reportes'));
    }

    public function finalizados()
    {
        $proyectosCulminados = Proyecto::where('activo', 0)
                                      ->with('user')
                                      ->orderBy('updated_at', 'desc')
                                      ->get();

        return view('admin.proyectos.finalizados', compact('proyectosCulminados'));
    }


    public function misAsignaciones()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $misProyectos = \App\Models\Proyecto::where('user_id', Auth::id())
                    ->where('visible', true)
                    ->orderBy('updated_at', 'desc')
                    ->get();

    return view('user.asignaciones', compact('misProyectos'));
}



public function toggleEstado(Request $request, $id)
{
    // 1. Buscamos el proyecto
    $proyecto = \App\Models\Proyecto::findOrFail($id);

    // 2. Lógica para cambiar VISIBILIDAD
    if ($request->has('visible')) {
        // Invertimos el valor actual (si es true pasa a false y viceversa)
        $proyecto->visible = !$proyecto->visible;
    }

    // 3. Lógica para cambiar ESTADO ACTIVO
    if ($request->has('activo')) {
        // Invertimos el valor actual
        $proyecto->activo = !$proyecto->activo;
    }

    // 4. Guardamos los cambios
    $proyecto->save();

    // 5. Retornamos con un mensaje opcional
    return back()->with('success', 'Proyecto actualizado exitosamente.');
}
}
