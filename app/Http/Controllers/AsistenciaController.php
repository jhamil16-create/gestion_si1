<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsignacionHorario;
use Illuminate\Http\Request;
use App\Models\Docente; // ← AGREGA ESTA LÍNEA
use App\Models\Grupo; // ← Y ESTA TAMBIÉN

class AsistenciaController extends Controller
{
    /**
     * Muestra la asistencia para una asignación de horario específica.
     * Ruta: /asignaciones/{asignacione}/asistencias
     */
    public function index(AsignacionHorario $asignacione)
    {
        // Cargamos el grupo, materia, docente para mostrar info en la vista
        $asignacione->load('grupo.materia', 'grupo.docente.usuario', 'aula');
        
        $asistencias = $asignacione->asistencias()->orderBy('fecha', 'desc')->get();
        
        return view('asistencias.index', compact('asignacione', 'asistencias'));
    }

    /**
     * Guarda un nuevo registro de asistencia.
     * Ruta: POST /asignaciones/{asignacione}/asistencias
     */
    public function store(Request $request, AsignacionHorario $asignacione)
    {
        $request->validate([
            'fecha' => 'required|date',
            'estado' => 'required|string|max:1', // P, F, L
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Verificamos si ya existe asistencia para esa fecha
        $existe = $asignacione->asistencias()
                             ->where('fecha', $request->fecha)
                             ->exists();
        
        if ($existe) {
            return back()->with('error', 'Ya existe un registro de asistencia para esta fecha.');
        }

        $asignacione->asistencias()->create([
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
        ]);

        return back()->with('success', 'Asistencia registrada.');
    }

    public function create()
    {
        // Datos básicos para el formulario de asistencia
        return view('asistencias.registrar', [
            'docentes' => Docente::with('usuario')->get(),
            'grupos' => \App\Models\Grupo::all(),
        ]);
    }

    /**
     * Elimina un registro de asistencia.
     * Ruta: DELETE /asistencias/{asistencia}
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return back()->with('success', 'Registro de asistencia eliminado.');
    }
}
