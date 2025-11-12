<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\AsignacionHorario;
use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; // ← Agregar este import si usas DB::

class AsistenciaController extends Controller
{
    /**
     * Muestra el listado general de asistencias con sus relaciones
     */
public function index()
{
    // Solo administradores necesitan la lista de docentes para filtrar
    if (Auth::user()->isAdmin()) {
        $docentes = Docente::with('usuario')->get();
    } else {
        $docentes = collect(); // Colección vacía para docentes normales
    }

    // Obtener las asistencias
    $asistencias = Asistencia::orderBy('fecha', 'desc')
        ->paginate(15);

    return view('asistencias.index', compact('asistencias', 'docentes'));
}

    /**
     * Muestra el formulario para registrar asistencia
     */
    public function create()
    {
        try {
            // Obtener el ID del docente logueado
            $docenteId = Auth::user()->docente->id_docente;
            
            // Verificar que el docente existe
            if (!$docenteId) {
                return redirect()->route('asistencias.index')
                            ->with('error', 'No se encontró el perfil de docente.');
            }

            // Obtener los IDs de grupos del docente
            $gruposIds = \DB::table('docente_grupo')
                ->where('id_docente', $docenteId)
                ->pluck('id_grupo')
                ->toArray();

            // Si no tiene grupos asignados
            if (empty($gruposIds)) {
                return redirect()->route('asistencias.index')
                            ->with('info', 'No tienes grupos asignados para registrar asistencia.');
            }

            // Obtener las asignaciones de esos grupos
            $asignaciones = AsignacionHorario::whereIn('id_grupo', $gruposIds)
                ->with(['grupo.materia', 'aula'])
                ->get();

            return view('asistencias.create', compact('asignaciones'));

        } catch (\Exception $e) {
            return redirect()->route('asistencias.index')
                        ->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
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