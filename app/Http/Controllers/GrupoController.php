<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\GestionAcademica;
use App\Models\Bitacora;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with('docente.usuario', 'materia', 'gestionAcademica')->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $docentes = Docente::with('usuario')->get();
        $materias = Materia::all();
        $gestiones = GestionAcademica::all();
        return view('grupos.create', compact('docentes', 'materias', 'gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:30',
            'capacidad' => 'required|integer|min:1',
            'id_docente' => 'required|exists:docente,id_docente',
            'sigla' => 'required|exists:materia,sigla',
            'id_gestion' => 'required|exists:gestion_academica,id_gestion',
        ]);

        $grupo = Grupo::create($request->all());

        // Obtener nombres para la descripción
        $docenteNombre = $grupo->docente->usuario->nombre ?? 'ID ' . $grupo->id_docente;
        $materiaNombre = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $gestionNombre = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Creó el grupo '{$grupo->nombre}' (Capacidad: {$grupo->capacidad}) para la materia '{$materiaNombre}', impartido por '{$docenteNombre}' en la gestión '{$gestionNombre}'",
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado.');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load('docente.usuario', 'materia', 'gestionAcademica', 'asignacionesHorario.aula');
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $docentes = Docente::with('usuario')->get();
        $materias = Materia::all();
        $gestiones = GestionAcademica::all();
        return view('grupos.edit', compact('grupo', 'docentes', 'materias', 'gestiones'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:30',
            'capacidad' => 'required|integer|min:1',
            'id_docente' => 'required|exists:docente,id_docente',
            'sigla' => 'required|exists:materia,sigla',
            'id_gestion' => 'required|exists:gestion_academica,id_gestion',
        ]);

        // Guardar valores antiguos para la bitácora
        $oldNombre = $grupo->nombre;
        $oldCapacidad = $grupo->capacidad;
        $oldDocente = $grupo->docente->usuario->nombre ?? 'ID ' . $grupo->id_docente;
        $oldMateria = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $oldGestion = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;

        $grupo->update($request->all());

        $newDocente = $grupo->docente->usuario->nombre ?? 'ID ' . $grupo->id_docente;
        $newMateria = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $newGestion = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó el grupo de '{$oldNombre} (Cap: {$oldCapacidad}, Doc: {$oldDocente}, Mat: {$oldMateria}, Gest: {$oldGestion})' a '{$grupo->nombre} (Cap: {$grupo->capacidad}, Doc: {$newDocente}, Mat: {$newMateria}, Gest: {$newGestion})'",
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado.');
    }

    public function destroy(Grupo $grupo)
    {
        try {
            $nombre = $grupo->nombre;
            $materia = $grupo->materia->nombre ?? $grupo->sigla;
            $docente = $grupo->docente->usuario->nombre ?? 'ID ' . $grupo->id_docente;

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó el grupo '{$nombre}' de la materia '{$materia}' impartido por '{$docente}'",
            ]);

            $grupo->delete();
            return redirect()->route('grupos.index')->with('success', 'Grupo eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar, este grupo tiene horarios asignados.');
        }
    }
}
