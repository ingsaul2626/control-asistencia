<?php

use App\Http\Controllers\{ ProfileController, AsistenciaController, ReporteController, ProyectoController,
AdminController, UserController, BitacoraController, NotificacionController };
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\DashboardController;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. RUTA RAÍZ
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('user.asignaciones');
    }
    return view('welcome', ['proyecto' => Proyecto::all()]);
})->name('welcome');

// RUTA DE ESPERA
Route::middleware(['auth'])->group(function () {
    Route::get('/waiting-approval', function () { return view('auth.waiting-approval'); })->name('waiting-approval');
});

Route::get('/', function () {
    // Aquí es donde falta enviar la variable
    $proyectos = Proyecto::all();

    // Debes pasarla usando with() o compact()
    return view('welcome', compact('proyectos'));
})->name('welcome');

// 2. RUTAS COMUNES
Route::middleware(['auth', 'verified', 'checkUserApproved'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'checkUserApproved'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

   Route::get('/waiting-approval', function () {
    return view('auth.waiting-approval');
})->name('waiting-approval');
});



    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::get('/bitacora/export', [BitacoraController::class, 'export'])->name('bitacora.export');

    Route::prefix('notificaciones')->group(function () {
        Route::get('/todas', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::get('/mis-notificaciones', [NotificacionController::class, 'misNotificaciones'])->name('user.notificaciones');
        Route::post('/marcar-leidas', [NotificacionController::class, 'marcarComoLeidas'])->name('notifications.markRead');
        Route::post('/{id}/leer', [NotificacionController::class, 'marcarUnaLeida'])->name('notifications.readOne');
    });
});

// 3. PANEL ADMINISTRADOR
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reporte-hoy', [ReporteController::class, 'reporteHoy'])->name('reporte.hoy');
    Route::get('/panel-control', [AdminController::class, 'panelControl'])->name('panelControl');

    // Rutas para gestión de usuarios
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::post('/usuarios/{id}/toggle', [UsuarioController::class, 'toggleAdmin'])
         ->name('admin.usuarios.toggle');

    Route::patch('/usuarios/{id}/approve', [UsuarioController::class, 'approve'])
         ->name('admin.usuarios.approve');

    Route::delete('/usuarios/{id}/decline', [UsuarioController::class, 'decline'])
         ->name('admin.usuarios.decline');


});
// Rutas CRUD para usuarios
    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'user']);
    Route::resource('asistencias', AsistenciaController::class);

    //rutas proyecto
    Route::get('/admin/proyectos', [ProyectoController::class, 'index'])->name('admin.proyectos.index');
    Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
    Route::post('/proyectos/asignar', [AdminController::class, 'asignarProyecto'])->name('proyectos.asignar');
    Route::get('/proyectos-finalizados', [ProyectoController::class, 'finalizados'])->name('proyectos.finalizados');
    Route::get('proyectos/reportes', [ProyectoController::class, 'reportes'])->name('proyectos.reportes');
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');

    Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');

    Route::get('admin/proyectos/{proyecto}/edit', [App\Http\Controllers\ProyectoController::class, 'edit'])
    ->name('proyectos.edit');

    Route::post('/proyectos', [App\Http\Controllers\ProyectoController::class, 'store'])->name('proyectos.store');

    Route::post('/proyectos/{id}/toggle', [App\Http\Controllers\ProyectoController::class, 'toggleEstado'])
         ->name('proyectos.toggle');

//faltas
    Route::post('/asistencias/marcar-falta/{id}', [AsistenciaController::class, 'marcarFalta'])
        ->name('asistencias.marcar-falta');

        Route::delete('/proyectos/{id}', [App\Http\Controllers\ProyectoController::class, 'destroy'])
         ->name('proyectos.destroy');

});

// 4. PANEL usuarios
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencia.index');

    // Rutas para ver proyectos asignados y reportar avances
    Route::post('/asistencia/{id}/aceptar', [AsistenciaController::class, 'aceptarAsistencia'])->name('asistencia.aceptar');
    Route::post('/asistencia/{id}/salida', [AsistenciaController::class, 'marcarSalida'])->name('asistencia.marcarSalida');


    Route::get('/mis-asignaciones', [UserController::class, 'myProjects'])->name('asignaciones');

    Route::put('/proyectos/{id}/reporte', [App\Http\Controllers\UserController::class, 'updateReport'])->name('proyectos.updateReport');
    Route::get('/proyectos/{id}/finalizar', [App\Http\Controllers\UserController::class, 'finalizarProyecto'])->name('proyectos.finalizar');


    Route::get('/proyectos/descargar/{id}', [UserController::class, 'descargarArchivo'])
         ->name('proyectos.descargar');
});

Route::get('/proyecto/{id}', [ProyectoController::class, 'show'])->name('eventos.show');

require __DIR__.'/auth.php';
