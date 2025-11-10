<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionController;

// Rutas de notificaciones
Route::middleware(['auth'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/marcar-leida/{id}', [NotificacionController::class, 'markAsRead'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [NotificacionController::class, 'markAllAsRead'])->name('notificaciones.marcar-todas-leidas');
    
    // Solo administradores
    Route::middleware(['admin'])->group(function () {
        Route::get('/notificaciones/crear', [NotificacionController::class, 'create'])->name('notificaciones.create');
        Route::post('/notificaciones', [NotificacionController::class, 'store'])->name('notificaciones.store');
        Route::delete('/notificaciones/{notificacion}', [NotificacionController::class, 'destroy'])->name('notificaciones.destroy');
    });
});