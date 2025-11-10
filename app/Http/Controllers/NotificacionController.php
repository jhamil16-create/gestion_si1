<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la vista de notificaciones - VERSIÓN SIMPLE
     */
    public function index()
    {
        // Notificaciones de ejemplo sin base de datos
        $notifications = [
            [
                'id' => 1,
                'title' => 'Bienvenido al sistema',
                'message' => 'El sistema está funcionando correctamente',
                'type' => 'info',
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 2,
                'title' => 'Recordatorio importante',
                'message' => 'No olvides completar tu perfil',
                'type' => 'warning', 
                'created_at' => now()->subDays(1)
            ]
        ];

        return view('notificaciones.index', compact('notifications'));
    }

    /**
     * Muestra el formulario para crear notificación.
     */
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('notificaciones.index')
                           ->with('error', 'No tienes permisos para esta acción.');
        }

        return view('notificaciones.create');
    }

    /**
     * Almacena una nueva notificación - VERSIÓN SIMPLE
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('notificaciones.index')
                           ->with('error', 'No tienes permisos para esta acción.');
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,success,danger'
        ]);

        // Solo muestra mensaje de éxito sin guardar en BD
        return redirect()->route('notificaciones.index')
                        ->with('success', 'Notificación "' . $request->title . '" creada exitosamente (modo demo)');
    }

    /**
     * Muestra el detalle de una notificación - VERSIÓN SIMPLE
     */
    public function show($id)
    {
        // Notificación de ejemplo
        $notification = [
            'id' => $id,
            'title' => 'Notificación de ejemplo',
            'message' => 'Esta es una notificación de demostración.',
            'type' => 'info',
            'created_at' => now()->subHours(5)
        ];

        return view('notificaciones.show', compact('notification'));
    }

    /**
     * Elimina una notificación - VERSIÓN SIMPLE
     */
    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('notificaciones.index')
                           ->with('error', 'No tienes permisos para esta acción.');
        }

        // Solo muestra mensaje sin eliminar de BD
        return redirect()->route('notificaciones.index')
                        ->with('success', 'Notificación eliminada (modo demo)');
    }
}