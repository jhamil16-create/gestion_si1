<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsignacionHorario;
use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Grupo;

class AsistenciaController extends Controller
{
    /**
     * Muestra el listado general de asistencias con sus relaciones
     */
    public function index()
    {
        $asistencias = Asistencia::with(['asignacionHorario.grupo.materia', 'asignacionHorario.grupo.docentes'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);

        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Muestra el formulario para registrar asistencia
     */
    public function create()
    {
        return view('asistencias.create', [
            'asignaciones' => AsignacionHorario::with(['grupo.materia', 'grupo.docentes'])->get(),
        ]);
    }

    /**
     * Guarda un nuevo registro de asistencia
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_asignacion' => 'required|exists:asignacion_horario,id_asignacion',
            'fecha' => 'required|date',
            'estado' => 'required|in:P,F,L', // Presente, Falta, Licencia
            'observaciones' => 'nullable|string|max:255',
        ]);

        try {
            Asistencia::create([
                'id_asignacion' => $request->id_asignacion,
                'fecha' => $request->fecha,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

            return redirect()->route('asistencias.index')
                           ->with('success', '✓ Asistencia registrada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar asistencia
     */
    public function edit(Asistencia $asistencia)
    {
        $asistencia->load('asignacionHorario.grupo.materia');
        
        return view('asistencias.edit', [
            'asistencia' => $asistencia,
            'asignaciones' => AsignacionHorario::with(['grupo.materia', 'grupo.docentes'])->get(),
        ]);
    }

    /**
     * Actualiza un registro de asistencia existente
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'id_asignacion' => 'required|exists:asignacion_horario,id_asignacion',
            'fecha' => 'required|date',
            'estado' => 'required|in:P,F,L', // Presente, Falta, Licencia
            'observaciones' => 'nullable|string|max:255',
        ]);

        try {
            $asistencia->update([
                'id_asignacion' => $request->id_asignacion,
                'fecha' => $request->fecha,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

            return redirect()->route('asistencias.index')
                           ->with('success', '✓ Asistencia actualizada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un registro de asistencia
     */
    public function destroy(Asistencia $asistencia)
    {
        try {
            $asistencia->delete();
            return back()->with('success', '✓ Asistencia eliminada correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la asistencia: ' . $e->getMessage());
        }
    }
}