<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function myProjects()
    {
        // 1. Obtenemos el ID del usuario que está logueado actualmente
        $userId = Auth::id();


        // 2. Buscamos SOLO los eventos donde el 'user_id' sea igual al del usuario logueado
       $misEventos = Evento::where('user_id', $userId)->get();
        // 3. Pasamos la variable a la vista (asegúrate que el nombre coincida)
        return view('user.dashboard', compact('misEventos'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateReport(Request $request, $id)
{
    $request->validate([
        'reporte_trabajador' => 'required|string|max:1000',
    ]);

    $evento = Evento::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();
    $evento->reporte_trabajador = $request->reporte_trabajador;
    $evento->update([
        'reporte_trabajador' => $request->reporte_trabajador
    ]);
    return back()->with('success', 'Reporte enviado al administrador.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    // Buscamos el proyecto y nos aseguramos de que pertenezca al usuario logueado
    $proyecto = Evento::where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

    $proyecto->delete();

    return back()->with('success', 'La tarea ha sido eliminada de tu lista.');
}

public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'cedula'   => 'required|unique:users,cedula',
        'password' => 'required|min:8',
        'role'     => 'required|in:user,admin',
    ]);

    // Creamos al trabajador directamente en la tabla de usuarios
    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'cedula'   => $request->cedula,
        'password' => Hash::make($request->password), // IMPORTANTE: Siempre encriptar
        'role'     => $request->role,
    ]);

    return redirect()->route('asistencias.index')->with('success', 'Trabajador registrado exitosamente como usuario.');
}


public function asistencias()
{
    return $this->hasMany(Asistencia::class, 'user_id');
}

public function ultimaAsistencia()
{
    return $this->hasOne(Asistencia::class, 'user_id')->latestOfMany('fecha');
}
}
