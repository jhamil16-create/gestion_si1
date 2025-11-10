<?php

namespace App\Http\Controllers;

use App\Models\AsignacionHorario;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Bitacora;
use Illuminate\Http\Request;

class AsignacionHorarioController extends Controller
{
    public function create(Grupo $grupo)
    {
        $aulas = Aula::all();
        return view('asignaciones.create', compact('grupo', 'aulas'));
    }

    public function store(Request $request, Grupo $grupo)
    {
        $request->validate([
            'dia' => 'required|string|max:10',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_aula' => 'required|exists:aula,id_aula',
        ]);

        $datos = $request->all();
        $datos['id_grupo'] = $grupo->id_grupo;

        $asignacion = AsignacionHorario::create($datos);

        // Obtener datos para la descripción
        $aulaTipo = $asignacion->aula->tipo ?? 'Aula ID ' . $asignacion->id_aula;
        $materiaNombre = $grupo->materia->nombre ?? $grupo->sigla;
        // Un grupo puede tener varios docentes; reunimos sus nombres (si existen)
        $docenteNombre = $grupo->docentes->pluck('usuario.nombre')->filter()->join(', ');
        if (empty($docenteNombre)) {
            $docenteNombre = 'Docente ID ' . ($grupo->id_docente ?? 'N/A');
        }

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Asignó horario para el grupo '{$grupo->nombre}' (Materia: {$materiaNombre}, Docente: {$docenteNombre}) en {$asignacion->dia} de {$asignacion->hora_inicio} a {$asignacion->hora_fin} en aula tipo '{$aulaTipo}'",
        ]);

        return redirect()->route('grupos.show', $grupo)->with('success', 'Horario asignado.');
    }

    public function edit(AsignacionHorario $asignacione)
    {
        $aulas = Aula::all();
        $grupo = $asignacione->grupo;
        return view('asignaciones.edit', compact('asignacione', 'aulas', 'grupo'));
    }

    public function update(Request $request, AsignacionHorario $asignacione)
    {
        $request->validate([
            'dia' => 'required|string|max:10',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_aula' => 'required|exists:aula,id_aula',
        ]);

        // Guardar valores antiguos
        $oldDia = $asignacione->dia;
        $oldInicio = $asignacione->hora_inicio;
        $oldFin = $asignacione->hora_fin;
        $oldAula = $asignacione->aula->tipo ?? 'Aula ID ' . $asignacione->id_aula;

        $asignacione->update($request->all());

        // Nuevos valores
        $newAula = $asignacione->aula->tipo ?? 'Aula ID ' . $asignacione->id_aula;
        $grupo = $asignacione->grupo;
        $materiaNombre = $grupo->materia->nombre ?? $grupo->sigla;

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó horario del grupo '{$grupo->nombre}' (Materia: {$materiaNombre}) de {$oldDia} {$oldInicio}–{$oldFin} en aula '{$oldAula}' a {$asignacione->dia} {$asignacione->hora_inicio}–{$asignacione->hora_fin} en aula '{$newAula}'",
        ]);

        return redirect()->route('grupos.show', $asignacione->grupo_id)->with('success', 'Horario actualizado.');
    }

    public function destroy(AsignacionHorario $asignacione)
    {
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
