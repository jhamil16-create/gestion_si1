<?php

namespace App\Http\Controllers;

use App\Models\AsignacionHorario;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AsignacionHorarioController extends Controller
{
    /**
     * Muestra el formulario para crear la asignación
     */
    public function create(Grupo $grupo)
    {
        $aulas = Aula::all();
        return view('asignaciones.create', compact('grupo', 'aulas'));
    }

    /**
     * Guarda la nueva asignación (CON VALIDACIÓN DE COLISIÓN - VERSIÓN CORREGIDA)
     */
    public function store(Request $request, Grupo $grupo)
    {
        $request->validate([
            'dia' => 'required|string|max:10',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_aula' => 'required|exists:aula,id_aula',
        ]);

        // --- INICIO DE VALIDACIÓN DE COLISIÓN CORREGIDA ---

        $nuevoDia = $request->input('dia');
        $nuevaHoraInicio = $request->input('hora_inicio');
        $nuevaHoraFin = $request->input('hora_fin');
        $nuevaAulaId = $request->input('id_aula');
        $gestionId = $grupo->id_gestion;

        // 1. OBTENER DOCENTES DEL GRUPO (desde DOCENTE_GRUPO)
        $docentesIds = \DB::table('docente_grupo')
            ->where('id_grupo', $grupo->id_grupo)
            ->pluck('id_docente')
            ->toArray();

        // 2. Buscar colisión de DOCENTE (CORREGIDO)
        $conflictoDocente = false;
        if (!empty($docentesIds)) {
            $conflictoDocente = AsignacionHorario::join('grupo', 'asignacion_horario.id_grupo', '=', 'grupo.id_grupo')
                ->join('docente_grupo', 'grupo.id_grupo', '=', 'docente_grupo.id_grupo')
                ->whereIn('docente_grupo.id_docente', $docentesIds)
                ->where('grupo.id_gestion', $gestionId)
                ->where('asignacion_horario.dia', $nuevoDia)
                ->where(function ($query) use ($nuevaHoraInicio, $nuevaHoraFin) {
                    $query->where('asignacion_horario.hora_inicio', '<', $nuevaHoraFin)
                        ->where('asignacion_horario.hora_fin', '>', $nuevaHoraInicio);
                })
                ->exists();
        }

        if ($conflictoDocente) {
            return back()->withInput()->with('error', 
                '¡Cruce de Horario! Uno de los docentes ya tiene una clase asignada en ese día y hora.');
        }

        // 3. Buscar colisión de AULA (CORREGIDO)
        $conflictoAula = AsignacionHorario::join('grupo', 'asignacion_horario.id_grupo', '=', 'grupo.id_grupo')
            ->where('grupo.id_gestion', $gestionId)
            ->where('asignacion_horario.id_aula', $nuevaAulaId)
            ->where('asignacion_horario.dia', $nuevoDia)
            ->where(function ($query) use ($nuevaHoraInicio, $nuevaHoraFin) {
                $query->where('asignacion_horario.hora_inicio', '<', $nuevaHoraFin)
                    ->where('asignacion_horario.hora_fin', '>', $nuevaHoraInicio);
            })
            ->exists();

        if ($conflictoAula) {
            return back()->withInput()->with('error', 
                '¡Aula Ocupada! El aula ya está siendo usada en ese día y hora. Por favor, escoja otra.');
        }

        // --- FIN DE VALIDACIÓN DE COLISIÓN ---

        // Si pasa las validaciones, se crea la asignación
        try {
            $datos = $request->all();
            $datos['id_grupo'] = $grupo->id_grupo;
            $asignacion = AsignacionHorario::create($datos);

            // Bitacora (actualizada para mostrar docentes correctamente)
            $aulaTipo = $asignacion->aula->tipo ?? 'Aula ID ' . $asignacion->id_aula;
            $materiaNombre = $grupo->materia->nombre ?? $grupo->sigla;
            
            // Obtener nombres de docentes desde la relación correcta
            $docentesNombres = \DB::table('docente_grupo')
                ->join('docente', 'docente_grupo.id_docente', '=', 'docente.id_docente')
                ->join('usuario', 'docente.id_usuario', '=', 'usuario.id_usuario')
                ->where('docente_grupo.id_grupo', $grupo->id_grupo)
                ->pluck('usuario.nombre')
                ->join(', ');

            if (empty($docentesNombres)) {
                $docentesNombres = 'Sin docente asignado';
            }

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Asignó horario para el grupo '{$grupo->nombre}' (Materia: {$materiaNombre}, Docentes: {$docentesNombres}) en {$asignacion->dia} de {$asignacion->hora_inicio} a {$asignacion->hora_fin} en aula tipo '{$aulaTipo}'",
            ]);

            return redirect()->route('grupos.show', $grupo)->with('success', 'Horario asignado.');

        } catch (\Exception $e) {
            Log::error("Error al guardar asignación: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error inesperado al guardar el horario.');
        }
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit(AsignacionHorario $asignacione)
    {
        $aulas = Aula::all();
        $grupo = $asignacione->grupo;
        return view('asignaciones.edit', compact('asignacione', 'aulas', 'grupo'));
    }

    /**
     * Actualiza una asignación (CON VALIDACIÓN DE COLISIÓN - VERSIÓN CORREGIDA)
     */
    public function update(Request $request, AsignacionHorario $asignacione)
    {
        $request->validate([
            'dia' => 'required|string|max:10',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_aula' => 'required|exists:aula,id_aula',
        ]);

        // --- INICIO DE VALIDACIÓN DE COLISIÓN (para UPDATE) ---

        $nuevoDia = $request->input('dia');
        $nuevaHoraInicio = $request->input('hora_inicio');
        $nuevaHoraFin = $request->input('hora_fin');
        $nuevaAulaId = $request->input('id_aula');

        $grupo = $asignacione->grupo;
        $docenteId = $grupo->id_docente;
        $gestionId = $grupo->id_gestion;
        
        // Asumiendo que la llave primaria es 'id_asignacion_horario'
        $idAsignacionActual = $asignacione->id_asignacion_horario; 

        // 2. Buscar colisión de DOCENTE (excluyéndose a sí mismo)
        // ---- CORRECCIÓN: Nombres de tablas en SINGULAR ----
        $conflictoDocente = AsignacionHorario::join('grupo', 'asignacion_horario.id_grupo', '=', 'grupo.id_grupo')
            ->where('grupo.id_docente', $docenteId)
            ->where('grupo.id_gestion', $gestionId)
            ->where('asignacion_horario.dia', $nuevoDia) // <-- singular
            ->where('asignacion_horario.id_asignacion_horario', '!=', $idAsignacionActual) // <-- singular
            ->where(function ($query) use ($nuevaHoraInicio, $nuevaHoraFin) {
                $query->where('asignacion_horario.hora_inicio', '<', $nuevaHoraFin) // <-- singular
                      ->where('asignacion_horario.hora_fin', '>', $nuevaHoraInicio); // <-- singular
            })
            ->exists();

        if ($conflictoDocente) {
            return back()->withInput()->with('error', 
                '¡Cruce de Horario! El docente ya tiene otra clase asignada en ese día y hora.');
        }

        // 3. Buscar colisión de AULA (excluyéndose a sí mismo)
        // ---- CORRECCIÓN: Nombres de tablas en SINGULAR ----
        $conflictoAula = AsignacionHorario::join('grupo', 'asignacion_horario.id_grupo', '=', 'grupo.id_grupo')
            ->where('grupo.id_gestion', $gestionId)
            ->where('asignacion_horario.id_aula', $nuevaAulaId) // <-- singular
            ->where('asignacion_horario.dia', $nuevoDia) // <-- singular
            ->where('asignacion_horario.id_asignacion_horario', '!=', $idAsignacionActual) // <-- singular
            ->where(function ($query) use ($nuevaHoraInicio, $nuevaHoraFin) {
                $query->where('asignacion_horario.hora_inicio', '<', $nuevaHoraFin) // <-- singular
                      ->where('asignacion_horario.hora_fin', '>', $nuevaHoraInicio); // <-- singular
            })
            ->exists();

        if ($conflictoAula) {
            return back()->withInput()->with('error', 
                '¡Aula Ocupada! El aula ya está siendo usada en ese día y hora. Por favor, escoja otra.');
        }

        // --- FIN DE VALIDACIÓN DE COLISIÓN ---

        // Si pasa las validaciones, se actualiza
        try {
            // ... (Tu código de Bitacora - valores antiguos) ...
            $oldDia = $asignacione->dia;
            $oldInicio = $asignacione->hora_inicio;
            $oldFin = $asignacione->hora_fin;
            $oldAula = $asignacione->aula->tipo ?? 'Aula ID ' . $asignacione->id_aula;

            $asignacione->update($request->all());

            // ... (Tu código de Bitacora - valores nuevos) ...
            $newAula = $asignacione->aula->tipo ?? 'Aula ID ' . $asignacione->id_aula;
            $materiaNombre = $grupo->materia->nombre ?? $grupo->sigla;

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => $request->ip(),
                'descripcion' => "Actualizó horario del grupo '{$grupo->nombre}' (Materia: {$materiaNombre}) de {$oldDia} {$oldInicio}–{$oldFin} en aula '{$oldAula}' a {$asignacione->dia} {$asignacione->hora_inicio}–{$asignacione->hora_fin} en aula '{$newAula}'",
            ]);

            return redirect()->route('grupos.show', $asignacione->grupo_id)->with('success', 'Horario actualizado.');
        
        } catch (\Exception $e) {
            Log::error("Error al actualizar asignación: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error inesperado al actualizar el horario.');
        }
    }

    /**
     * Elimina una asignación
     */
    public function destroy(AsignacionHorario $asignacione)
    {
        // Tu código de 'destroy' está perfecto y no necesita cambios.
        try {
            $grupo = $asignacione->grupo;
            $materiaNombre = $grupo->materia->nombre ?? $grupo->sigla;
            $aulaTipo = $asignacione->aula->tipo ?? 'Aula ID ' . $asignacione->id_aula;

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó horario del grupo '{$grupo->nombre}' (Materia: {$materiaNombre}) en {$asignacione->dia} {$asignacione->hora_inicio}–{$asignacione->hora_fin} en aula tipo '{$aulaTipo}'",
            ]);

            $asignacione->delete();
            return back()->with('success', 'Horario eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar, esta asignación tiene asistencias registradas.');
        }
    }
}