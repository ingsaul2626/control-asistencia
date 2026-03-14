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

        return view('user.dashboard', compact('misProyectos', 'historialAsistencias', 'totalHorasMes', 'diasAsistidos'));
    }

    public function myProjects()
    {
        $misProyectos = Proyecto::where('user_id', Auth::id())->get();
        return view('user.dashboard', compact('misProyectos'));
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
            'telefono'        => $request->telefono, // ¿Estás recibiendo esto del form?
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
        $evento = Proyecto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $evento->update(['reporte_trabajador' => $request->reporte_trabajador]);
        return back()->with('success', 'Reporte enviado al administrador.');
    }

}
