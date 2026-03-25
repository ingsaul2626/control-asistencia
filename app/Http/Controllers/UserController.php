<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Muestra el dashboard del usuarios
    public function index()
    {

         if (auth()->user()->role === 'operador') {
        $usuarios = User::where('id', '!=', 1)->get();
        } else {
        $usuarios = User::all();
         }

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

   public function descargarArchivo($id)
{
    $proyecto = Proyecto::findOrFail($id);

    // Cambiado de archivo_pdf a archivo
    if ($proyecto->archivo && Storage::disk('public')->exists($proyecto->archivo)) {
        return Storage::disk('public')->download($proyecto->archivo);
    }

    return back()->with('error', 'El archivo no está disponible en el servidor.');
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
       $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|unique:users,email',
        'cedula'          => 'required|string|max:8|unique:users,cedula',
        'password'        => 'required|min:8',
        'role'            => 'required|in:user,admin',
        'tipo_trabajador' => 'required|string',
        'seccion'         => 'required|string',
        'telefono'        => 'required|numeric|digits_between:10,11',
        'cargo'           => 'required|in:Docente Ordinario,Administrativo Fijo,Administrativo Contratado,Obrero',
        'security_question' => 'required|string',
        'security_answer'   => 'required|string',
    ]);

    // 2. Guardar (Aquí estaba el error, faltaban los campos)
    User::create([
        'name'              => $request->name,
        'email'             => $request->email,
        'cedula'            => $request->cedula,
        'password'          => Hash::make($request->password),
        'role'              => $request->role,
        'tipo_trabajador'   => $request->tipo_trabajador,
        'seccion'           => $request->seccion,
        'telefono'          => $request->telefono,
        'cargo'             => $request->cargo,
        'security_question' => $request->security_question,
        'security_answer'   => $request->security_answer,


    ]);
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);


        return redirect()->route('admin.usuarios.index')->with('success', 'usuarios registrado exitosamente.');

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($id == 1 && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'No puedes cambiar el rol del administrador raíz.');

        $user->update($request->only([
        'name', 'email', 'telefono', 'cargo', 'tipo_trabajador', 'seccion', 'role'
        ]));
        }
        $users = User::findOrFail($id);
        $users->update($request->all());
        return redirect()->back()->with('success', 'usuarios actualizado correctamente.');
    }

   public function edit($id)
{
    // 1. Bloqueo estricto para el Operador sobre el ID 1
   if ($id == 1 && Auth::user()->role === 'operador') {
    abort(403, 'Acceso denegado: El Administrador Principal es intocable.');
}

    // 2. Buscamos al usuario. Si no existe, enviará un error 404 automáticamente.
    $usuario = User::findOrFail($id);

    // 3. Verificación de la ruta de la vista (Asegúrate que la carpeta sea 'usuarios')
    return view('admin.usuarios.edit', compact('usuario'));
}


    public function destroy($id)
    {
    // 1. Validar que no sea el admin principal
    if ($id == 1) {
        return redirect()->back()->with('error', 'El administrador principal no puede ser eliminado.');

        $usuario = User::findOrFail($id);
        $usuario->delete();

        return back()->with('success', 'Usuario eliminado.');


    }

    // 2. Buscar al usuario y borrarlo permanentemente
    $user = \App\Models\User::withTrashed()->findOrFail($id);
    $user->forceDelete();

    return back()->with('success', 'El usuario ha sido eliminado permanentemente.');
    }

    public function updateReport(Request $request, $id)
    {
        $request->validate(['reporte_trabajador' => 'required|string|max:1000']);
        $misProyectos = Proyecto::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $misProyectos->update(['reporte_trabajador' => $request->reporte_trabajador]);
        return back()->with('success', 'Reporte enviado al administrador.');
    }



    public function updateRole(Request $request, User $user)
    {
        // Solo el admin puede cambiar roles
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'No autorizado.');
        }

        $request->validate(['role' => 'required|in:admin,operador,user']);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Rol actualizado correctamente.');
    }


    public function unlock($id)
{
    $user = User::findOrFail($id);

    // Asegúrate de usar el nombre correcto: 'is_approved' o 'is_active'
    $user->update(['is_approved' => true]);

    // Limpiar los intentos fallidos
    // Ahora 'Str' funcionará correctamente con el import
    $key = Str::lower($user->email) . '|' . request()->ip();
    app(\Illuminate\Cache\RateLimiter::class)->clear($key);

    return back()->with('success', "Usuario {$user->name} desbloqueado correctamente.");
}
}


