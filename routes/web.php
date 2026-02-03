<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, AsistenciaController, EmpleadoController,
    ReporteController, EventoController, AdminController, UserController
};
// Importante: Importar el controlador de administración de usuarios
use App\Http\Controllers\Admin\UsuarioController;
use App\Models\{Evento, Empleado, Asistencia};

// 1. RUTA PÚBLICA
Route::get('/', function () {
    $eventos = Evento::all();
    return view('welcome', compact('eventos'));
})->name('welcome');

// 2. RUTAS COMUNES (AUTH)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Genérico
    Route::get('/dashboard', function () {
        $totalEmpleados = Empleado::count();
        $asistenciasHoy = Asistencia::whereDate('fecha', today())->get();
        $idPresentes = $asistenciasHoy->pluck('user_id');
        $empleadosAusentes = Empleado::whereNotIn('id', $idPresentes)->get();

        return view('dashboard', compact(
            'totalEmpleados',
            'empleadosAusentes'
        ) + [
            'conteoPresentes' => $asistenciasHoy->count(),
            'conteoAusentes' => $empleadosAusentes->count(),
            'porcentajeAsistencias' => $totalEmpleados > 0 ? round(($asistenciasHoy->count() / $totalEmpleados) * 100) : 0
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/asistencias/marcar-auto', [AsistenciaController::class, 'marcarSalidaAuto'])
         ->name('asistencias.marcar-salida-auto');
});

// 3. PANEL ADMINISTRADOR (ROL: ADMIN)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reporte-hoy', [ReporteController::class, 'reporteHoy'])->name('reporte.hoy');

    // Gestión de Usuarios (LA RUTA QUE FALTABA)
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleAdmin'])->name('usuarios.toggle');

    // Recursos
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('asistencias', AsistenciaController::class);

    // Proyectos y Reportes
    Route::get('proyectos/reportes', [EventoController::class, 'reportes'])->name('proyectos.reportes');
    Route::resource('proyectos', EventoController::class);
    Route::post('/proyectos/asignar', [EventoController::class, 'asignar'])->name('proyectos.asignar');

    Route::patch('/empleados/{id}/finalizar', [EmpleadoController::class, 'finalizarJornada'])
         ->name('empleados.finalizar');
});

// 4. PANEL USUARIO / TRABAJADOR (ROL: USER)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/mis-tareas', [UserController::class, 'myProjects'])->name('projects');
    Route::post('/reportar/{id}', [UserController::class, 'updateReport'])->name('reportar');
    Route::get('/descargar/{id}', [UserController::class, 'descargar'])->name('descargar');
});

Route::post('/asistencias/marcar-salida-auto', [App\Http\Controllers\AsistenciaController::class, 'marcarSalidaAuto'])
    ->name('asistencias.marcar-salida-auto')
    ->middleware('auth');

    Route::get('/test-asistencia', function() {
    return [
        'Usuario_Conectado' => auth()->user()->name ?? 'Nadie conectado',
        'ID_Usuario' => auth()->id(),
        'Hora_Servidor' => now()->toDateTimeString(),
        'Zona_Horaria' => config('app.timezone'),
        'Registros_Hoy' => \App\Models\Asistencia::where('fecha', now()->toDateString())->count()
    ];
})->middleware('auth');
Route::middleware(['auth'])->group(function () {
    // Rutas del Usuario
    Route::post('/asistencias/marcar-auto', [AsistenciaController::class, 'marcarSalidaAuto'])
          ->name('asistencias.marcar-salida-auto');

    // Rutas del Admin
    Route::post('/admin/asistencias/store', [AsistenciaController::class, 'store'])
          ->name('admin.asistencias.store');
});

Route::prefix('admin')->name('admin.')->group(function() {
    // Ruta para el botón Registrar/Actualizar y Falta
    Route::post('/asistencias/store', [AsistenciaController::class, 'store'])->name('asistencias.store');

    // Ruta para el botón naranja "Marcar mi salida ahora"
    Route::post('/asistencias/marcar-salida-auto', [AsistenciaController::class, 'marcarSalidaAuto'])->name('asistencias.marcar-salida-auto');
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... otras rutas ...

    // ESTA ES LA QUE FALTA:
    Route::post('/asistencias/marcar-falta', [AsistenciaController::class, 'marcarFalta'])
         ->name('asistencias.marcar-falta');
});
Route::middleware(['auth'])->group(function () {
    // Ruta para que el usuario acepte el horario
    Route::post('/asistencias/aceptar', [AsistenciaController::class, 'aceptarHorario'])
        ->name('usuario.asistencias.aceptar');

    // Ruta para que el usuario marque su salida
    Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalidaUsuario'])
        ->name('usuario.asistencias.salida');
});
// Rutas para el Administrador
Route::prefix('admin')->name('admin.')->group(function() {
    Route::post('/asistencias/store', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::post('/asistencias/falta', [AsistenciaController::class, 'marcarFalta'])->name('asistencias.marcar-falta');
});

// Rutas para el Usuario (Dashboard)
Route::middleware(['auth'])->group(function () {
    Route::post('/asistencias/aceptar', [AsistenciaController::class, 'aceptarHorario'])->name('usuario.asistencias.aceptar');
    Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalidaUsuario'])->name('usuario.asistencias.salida');
});
// Cambia esto:
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Por esto:
Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
require __DIR__.'/auth.php';
