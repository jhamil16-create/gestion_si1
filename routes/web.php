<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\GestionAcademicaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\AsignacionHorarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web de tu aplicación.
| Se cargan dentro del grupo de middleware 'web' y 'auth'.
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Bitácora (solo lectura y eliminación por admins, si aplica)
    Route::resource('bitacoras', BitacoraController::class)->only(['index', 'show', 'destroy']);

    // Materias
    Route::resource('materias', MateriaController::class);

    // Docentes
    Route::resource('docentes', DocenteController::class);

    // Administradores
    Route::resource('administradores', AdministradorController::class)
    ->parameters(['administradores' => 'administrador']);

    // Gestiones Académicas
    Route::resource('gestiones', GestionAcademicaController::class)->names([
        'index' => 'gestiones.index',
        'create' => 'gestiones.create',
        'store' => 'gestiones.store',
        'edit' => 'gestiones.edit',
        'update' => 'gestiones.update',
        'destroy' => 'gestiones.destroy',
    ]);

    // Aulas
    Route::resource('aulas', AulaController::class);

    // Grupos
    Route::resource('grupos', GrupoController::class);

    // Asignaciones de Horario (anidadas bajo grupos)
    Route::prefix('grupos/{grupo}')->group(function () {
        Route::get('/asignaciones/create', [AsignacionHorarioController::class, 'create'])->name('asignaciones.create');
        Route::post('/asignaciones', [AsignacionHorarioController::class, 'store'])->name('asignaciones.store');
    });

    // Asignaciones (rutas independientes para edit/update/destroy)
    Route::resource('asignaciones', AsignacionHorarioController::class)
        ->only(['edit', 'update', 'destroy'])
        ->names([
            'edit' => 'asignaciones.edit',
            'update' => 'asignaciones.update',
            'destroy' => 'asignaciones.destroy',
        ]);

    // Ruta raíz (dashboard o redirección)
    Route::get('/', function () {
        return view('welcome'); // o redirige a un panel, ej: redirect()->route('materias.index')
    })->name('home');
});
