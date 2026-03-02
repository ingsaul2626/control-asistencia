<php


public function show($id)
{
    // Buscamos el proyecto con su usuario asignado para ver quién envió el reporte
    $proyecto = Evento::with('user')->findOrFail($id);
    return view('admin.proyectos.show', compact('proyecto'));
}
