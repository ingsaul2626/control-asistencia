<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController, AsistenciaController, EmpleadoController,
    ReporteController, EventoController, AdminController, UserController,
};
use App\Http\Controllers\Admin\UsuarioController;
use App\Models\{Evento, Empleado, Asistencia};
use App\Http\Controllers\BitacoraController;
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

    // Dashboard General (Inicio)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Asistencia para el Usuario
    Route::post('/asistencias/aceptar', [AsistenciaController::class, 'aceptarHorario'])->name('usuario.asistencias.aceptar');
    Route::post('/asistencias/salida', [AsistenciaController::class, 'marcarSalidaUsuario'])->name('usuario.asistencias.salida');
    Route::post('/asistencias/marcar-auto', [AsistenciaController::class, 'marcarSalidaAuto'])->name('asistencias.marcar-salida-auto');
});

// 3. PANEL ADMINISTRADOR (ROL: ADMIN)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Inicio y Reportes (SOLUCIÓN AL ERROR)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reporte-hoy', [ReporteController::class, 'reporteHoy'])->name('reporte.hoy');
    Route::get('/panel-control', [AdminController::class, 'panelControl'])->name('admin.panelControl');
    Route::post('/proyectos/asignar', [AdminController::class, 'asignarProyecto'])->name('proyectos.asignar');
    Route::get('/admin/proyectos/{id}', [EventoController::class, 'show'])->name('admin.proyectos.show');
   Route::get('/proyectos-finalizados', [App\Http\Controllers\EventoController::class, 'finalizados'])
    ->name('admin.proyectos.finalizados');

    // Gestión de Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleAdmin'])->name('usuarios.toggle');

    // Recursos
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('asistencias', AsistenciaController::class);

    // Acciones de Asistencia Admin
    Route::post('/asistencias/store', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::post('/asistencias/falta', [AsistenciaController::class, 'marcarFalta'])->name('asistencias.marcar-falta');

    // Proyectos y Reportes
    Route::get('proyectos/reportes', [EventoController::class, 'reportes'])->name('proyectos.reportes');
    Route::resource('proyectos', EventoController::class);
    Route::post('/proyectos/asignar', [EventoController::class, 'asignar'])->name('proyectos.asignar');
    Route::patch('/empleados/{id}/finalizar', [EmpleadoController::class, 'finalizarJornada'])->name('empleados.finalizar');
});

// 4. PANEL USUARIO / TRABAJADOR (ROL: USER)
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/mis-tareas', [UserController::class, 'myProjects'])->name('projects');
    Route::post('/reportar/{id}', [UserController::class, 'updateReport'])->name('reportar');
    Route::get('/descargar/{id}', [UserController::class, 'descargar'])->name('descargar');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::get('/bitacora/export', [BitacoraController::class, 'export'])->name('bitacora.export');
});
require __DIR__.'/auth.php';
