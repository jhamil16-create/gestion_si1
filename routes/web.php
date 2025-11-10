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
use App\Http\Controllers\DocenteGrupoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\DocentePanelController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;

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

    // Bitácora
    Route::resource('bitacoras', BitacoraController::class)->only(['index', 'show', 'destroy']);

    // Materias
    Route::resource('materias', MateriaController::class);

    // Docentes - Rutas fijas primero
    Route::get('/docentes/lista-para-admin', [DocenteController::class, 'listaParaAdmin'])
        ->name('docentes.lista-para-admin');
    
    // Luego el resource que contiene rutas con parámetros
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

    // --- Rutas para Asignar Docente a Grupo ---
    Route::get('/asignar-docente-grupo', [DocenteGrupoController::class, 'create'])->name('docente_grupo.create');
    Route::post('/asignar-docente-grupo', [DocenteGrupoController::class, 'store'])->name('docente_grupo.store');
    Route::get('/api/grupos-por-materia', [DocenteGrupoController::class, 'getGruposPorMateria'])->name('api.grupos_por_materia');

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
        return view('welcome');
    })->name('home');

    // ===================================================
    // RUTAS PARA IMPORTAR/EXPORTAR CATÁLOGOS
    // ===================================================
    Route::get('/catalogos', [CatalogoController::class, 'index'])->name('catalogos.index');

    // Aulas (ya las tienes)
    Route::get('/exportar/aulas', [CatalogoController::class, 'exportarAulas'])->name('aulas.export');
    Route::post('/importar/aulas', [CatalogoController::class, 'importarAulas'])->name('aulas.import');

    // Materias (AGREGA ESTAS)
    Route::get('/exportar/materias', [CatalogoController::class, 'exportarMaterias'])->name('materias.export');
    Route::post('/importar/materias', [CatalogoController::class, 'importarMaterias'])->name('materias.import');

    // Docentes (AGREGA ESTAS)  
    Route::get('/exportar/docentes', [CatalogoController::class, 'exportarDocentes'])->name('docentes.export');
    Route::post('/importar/docentes', [CatalogoController::class, 'importarDocentes'])->name('docentes.import');

    // Grupos (AGREGA ESTAS)
    Route::get('/exportar/grupos', [CatalogoController::class, 'exportarGrupos'])->name('grupos.export');
    Route::post('/importar/grupos', [CatalogoController::class, 'importarGrupos'])->name('grupos.import');

    Route::get('/planificar-horarios', [PublicacionController::class, 'index'])
    ->name('horarios.planificar.index');

    Route::post('/publicar-gestion/{gestion}', [PublicacionController::class, 'publicar'])
    ->name('horarios.publicar.gestion');

    Route::post('/despublicar-gestion/{gestion}', [PublicacionController::class, 'despublicar'])
    ->name('horarios.despublicar.gestion');

    // ===================================================
    // RUTAS DE CARGA DOCENTE (ORDENADAS POR PRIORIDAD)
    // ===================================================

    // 1. Rutas fijas sin parámetros (mayor prioridad)
    Route::get('/docentes/lista-para-admin', [DocenteController::class, 'listaParaAdmin'])
        ->name('docentes.lista-para-admin');

    Route::get('/mi-carga', [DocentePanelController::class, 'miCarga'])
        ->name('docente.miCarga');

    // 2. Rutas con parámetros (menor prioridad)
    Route::get('/ver-carga/{docente}', [DocentePanelController::class, 'mostrarCarga'])
        ->name('docente.verCarga')
        ->where('docente', '[0-9]+'); // Solo permite números

    // ===================================================
    // RUTAS PARA BOTONES DEL LAYOUT
    // ===================================================
    
// Para ADMIN - Lista de docentes para ver horarios
    Route::get('/admin/horarios/docentes', [HorarioController::class, 'listaDocentes'])
    ->name('horarios.docentes')
    ->middleware('auth');

// Para ADMIN - Horario específico de un docente  
    Route::get('/admin/horarios/docente/{docente}', [HorarioController::class, 'horarioDocente'])
    ->name('horarios.docente')
    ->middleware('auth');

// Para DOCENTE - Su propio horario
    Route::get('/docente/mi-horario', [HorarioController::class, 'miHorario'])
    ->name('docente.mi-horario')
    ->middleware('auth');

    // Asistencias - Rutas específicas
    Route::middleware(['auth'])->group(function () {
        Route::get('/asistencias/registrar', [AsistenciaController::class, 'create'])
            ->name('asistencias.registrar');
        Route::post('/asistencias', [AsistenciaController::class, 'store'])
            ->name('asistencias.store');
        Route::get('/asistencias', [AsistenciaController::class, 'index'])
            ->name('asistencias.index');
    });

    // Notificaciones
    Route::resource('notificaciones', NotificacionController::class);

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');
    Route::post('/reportes/generar', [ReporteController::class, 'generar'])
        ->name('reportes.generar');

    // Gestión de usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])
        ->name('usuarios.index');

    // Agrega esta ruta temporal para debug
    // Agrega esta ruta temporal para debug
    Route::get('/debug/horario-datos', [HorarioController::class, 'debugDatos']);
    Route::get('/debug/horario-datos/{id}', [HorarioController::class, 'debugDatos']);
});