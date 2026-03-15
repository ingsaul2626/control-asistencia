<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Evento;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Muestra el dashboard del usuarios
    public function index()
    {
        $user = Auth::user();
        $usersId = Auth::id();
        $mesActual = now()->month;

        $historialAsistencias = Asistencia::where('user_id', $usersId)
            ->whereMonth('fecha', $mesActual)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalHorasMes = $historialAsistencias->sum('horas_trabajadas');
        $diasAsistidos = $historialAsistencias->where('status', 'finalizado')->count();
        $misProyectos = Proyecto::where('user_id', $usersId)->get();

        return view('user.asignaciones', compact('misProyectos', 'historialAsistencias', 'totalHorasMes', 'diasAsistidos'));
    }

    public function myProjects()
    {
        $userId = Auth::id();

        $misProyectos = \App\Models\Proyecto::where('user_id', $userId)->get();
       
        $asistencia_hoy = \App\Models\Asistencia::where('user_id', $userId)
                        ->whereDate('fecha', now()->toDateString())
                        ->first();

        return view('user.asignaciones', compact('misProyectos', 'asistencia_hoy'));
        
    }
    
    public function descargarArchivo($id, $tipo)
    {
        // 1. Buscamos el proyecto
        $proyecto = \App\Models\Proyecto::findOrFail($id);

        // 2. Determinamos qué campo queremos descargar ('archivo' o 'imagen')
        $path = ($tipo === 'pdf') ? $proyecto->archivo : $proyecto->imagen;

        // 3. Verificamos que el archivo realmente exista en el almacenamiento
        if (!$path || !\Illuminate\Support\Facades\Storage::exists($path)) {
            return back()->with('error', 'El archivo no existe.');
        }

        // 4. Retornamos la respuesta de descarga
        return \Illuminate\Support\Facades\Storage::download($path);
    }

    public function finalizarProyecto($id)
    {
        $proyecto = \App\Models\Proyecto::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $proyecto->update(['activo' => 0]); // O el campo que uses para marcar como finalizado

        return back()->with('success', '¡Proyecto marcado como finalizado!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'cedula'          => 'required|string|max:8|unique:users,cedula',
            'password'        => 'required|min:8',
            'role'            => 'required|in:user,admin',
            'tipo_trabajador' => 'nullable|string',
            'telefono' => 'required|numeric|digits_between:10,11',
            'seccion'         => 'nullable|string',
            'cargo'           => [ 'required','in:Docente Ordinario,Administrativo Fijo,Administrativo Contratado,Obrero'],
            'is_approval'     => false,
            'status'          => 'pending',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'cedula'          => $request->cedula,
            'password'        => Hash::make($request->password),
            'role'            => $request->role,
            'tipo_trabajador' => $request->tipo_trabajador,
            'telefono'        => $request->telefono, 
            'cargo'           => $request->cargo,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'usuarios registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        if ($id == 1 && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'No puedes cambiar el rol del administrador raíz.');
        }
        $users = User::findOrFail($id);
        $users->update($request->all());
        return redirect()->back()->with('success', 'usuarios actualizado correctamente.');
    }

    public function destroy($id)
    {
        if ($id == 1) {
            return redirect()->back()->with('error', 'El administrador principal no puede ser eliminado.');
        }
        User::findOrFail($id)->delete();
        return back()->with('success', 'El usuarios ha sido eliminado correctamente.');
    }

    public function updateReport(Request $request, $id)
    {
        $request->validate(['reporte_trabajador' => 'required|string|max:1000']);
        $misProyectos = Proyecto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $misProyectos->update(['reporte_trabajador' => $request->reporte_trabajador]);
        return back()->with('success', 'Reporte enviado al administrador.');
    }

}
