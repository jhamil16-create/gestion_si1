<?php

namespace App\Http\Controllers;

// Importaciones necesarias
use Illuminate\Http\Request;
use App\Models\GestionAcademica; // <-- Modelo de Gestión
use App\Models\Bitacora;          // <-- Modelo de Bitácora
use Illuminate\Support\Facades\Auth;  // <-- Para el ID de usuario
use Illuminate\Support\Facades\Log;   // <-- Para registrar errores

class PublicacionController extends Controller
{

    /**
     * MÉTODO INDEX (EL QUE DABA EL ERROR)
     * Muestra la página de planificación con listas de gestiones.
     */
    public function index()
    {
        try {
            Log::info('Entrando a PublicacionController@index'); // Log para ver si entra

            $gestionesBorrador = GestionAcademica::where('estado', 'borrador')->get();
            $gestionesPublicadas = GestionAcademica::where('estado', 'publicado')->get();

            return view('horarios.planificar', [
                'gestionesBorrador' => $gestionesBorrador,
                'gestionesPublicadas' => $gestionesPublicadas,
            ]);

        } catch (\Exception $e) {
            Log::error('Error en PublicacionController@index: ' . $e->getMessage());
            // Devuelve un error 500 con un mensaje claro
            abort(500, "Error al cargar datos para la planificación: " . $e->getMessage());
        }
    }

    /**
     * MÉTODO PUBLICAR
     * Cambia el estado de una gestión a 'publicado'.
     */
    public function publicar(Request $request, GestionAcademica $gestion)
    {
        try {
            $gestion->estado = 'publicado';
            $gestion->save();

            Bitacora::create([
                'id_usuario' => Auth::id(),
                'accion' => 'Publicar horarios',
                'descripcion' => 'Se publicaron los horarios de la gestión: ' . $gestion->nombre,
            ]);

            return redirect()->route('horarios.planificar.index')
                             ->with('success', 'Gestión publicada. Los horarios ya son visibles.');

        } catch (\Exception $e) {
            Log::error('Error en PublicacionController@publicar: ' . $e->getMessage());
            return redirect()->route('horarios.planificar.index')
                             ->with('error', 'Error al publicar la gestión.');
        }
    }

    /**
     * MÉTODO DESPUBLICAR
     * Cambia el estado de una gestión a 'borrador'.
     */
    public function despublicar(Request $request, GestionAcademica $gestion)
    {
        try {
            $gestion->estado = 'borrador';
            $gestion->save();

            Bitacora::create([
                'id_usuario' => Auth::id(),
                'accion' => 'Despublicar horarios',
                'descripcion' => 'Se ocultaron los horarios de la gestión: ' . $gestion->nombre,
            ]);

            return redirect()->route('horarios.planificar.index')
                             ->with('success', 'Gestión despublicada correctamente.');

        } catch (\Exception $e) {
            Log::error('Error en PublicacionController@despublicar: ' . $e->getMessage());
            return redirect()->route('horarios.planificar.index')
                             ->with('error', 'Error al despublicar la gestión.');
        }
    }

}