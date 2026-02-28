<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, AsistenciaController, EmpleadoController,
    ReporteController, EventoController, AdminController, UserController,
    BitacoraController, NotificacionController
};
use App\Http\Controllers\Admin\UsuarioController;
use App\Models\{Evento, Empleado, Asistencia}; // Importación de modelos

// 1. RUTA RAÍZ
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }
    $eventos = Evento::all();
    return view('welcome', compact('eventos'));
})->name('welcome');

// 2. RUTAS COMUNES (AUTH)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard General
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Asistencias
    Route::post('/asistencias/aceptar', [AsistenciaController::class, 'aceptarHorario'])->name('usuario.asistencias.aceptar');
    Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalidaUsuario'])->name('usuario.asistencias.salida');
    Route::post('/asistencias/marcar-auto', [AsistenciaController::class, 'marcarSalidaAuto'])->name('asistencias.marcar-salida-auto');

    // Bitácora y Notificaciones

    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::get('/bitacora/export', [BitacoraController::class, 'export'])->name('bitacora.export');
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
});

// 3. PANEL ADMINISTRADOR (ROL: ADMIN)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reporte-hoy', [ReporteController::class, 'reporteHoy'])->name('reporte.hoy');
    Route::get('/panel-control', [AdminController::class, 'panelControl'])->name('admin.panelControl');
    Route::post('/proyectos/asignar', [AdminController::class, 'asignarProyecto'])->name('proyectos.asignar');
    Route::get('/proyectos/{id}', [EventoController::class, 'show'])->name('proyectos.show');
    Route::get('/proyectos-finalizados', [EventoController::class, 'finalizados'])->name('proyectos.finalizados');

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleAdmin'])->name('usuarios.toggle');

    Route::resource('empleados', EmpleadoController::class);
    Route::resource('asistencias', AsistenciaController::class);

    Route::post('/asistencias/store', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::post('/asistencias/falta', [AsistenciaController::class, 'marcarFalta'])->name('asistencias.marcar-falta');

    Route::get('proyectos/reportes', [EventoController::class, 'reportes'])->name('proyectos.reportes');
    Route::resource('proyectos', EventoController::class);
    Route::patch('/empleados/{id}/finalizar', [EmpleadoController::class, 'finalizarJornada'])->name('empleados.finalizar');

    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones');
});

// 4. PANEL USUARIO / TRABAJADOR (ROL: USER)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // RUTA ACTUALIZADA: Obtiene proyectos reales del usuario
    Route::get('/mis-asignaciones', function () {
        $misEventos = Evento::where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Retornamos la vista (asegúrate que el archivo sea resources/views/user/asignaciones.blade.php)
        return view('user.asignaciones', compact('misEventos'));
    })->name('asignaciones');

    Route::get('/mis-tareas', [UserController::class, 'myProjects'])->name('projects');
    Route::post('/reportar/{id}', [UserController::class, 'updateReport'])->name('reportar');
    Route::get('/descargar/{id}', [UserController::class, 'descargar'])->name('descargar');
});

// Otros
require __DIR__.'/auth.php';
