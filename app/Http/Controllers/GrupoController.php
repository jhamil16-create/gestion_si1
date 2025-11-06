<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\GestionAcademica;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Importante para la validación de 'update'

class GrupoController extends Controller
{
    public function index()
    {
        // Esto está bien, carga las relaciones para mostrar en la tabla
        $grupos = Grupo::with('docentes.usuario', 'materia', 'gestionAcademica')->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        // Pasamos las variables que el formulario necesita
        $materias = Materia::all();
        $gestiones = GestionAcademica::all();
        
        // Ya no pasamos 'docentes' porque el formulario no lo usa
        return view('grupos.create', compact('materias', 'gestiones'));
    }

    public function store(Request $request)
    {
        // --- INICIO CORRECCIÓN 'store' ---
        
        // 1. Validamos los campos del NUEVO formulario
        $request->validate([
            // AGREGADO: Validamos el ID manual
            'id_grupo' => 'required|string|max:20|unique:grupo,id_grupo',
            'nombre' => 'required|string|max:30',
            // ELIMINADO: 'id_docentes' ya no se valida aquí
            'sigla' => 'required|exists:materia,sigla',
            'id_gestion' => 'required|exists:gestion_academica,id_gestion',
        ]);

        // 2. Creamos el grupo solo con los datos del formulario
        $grupo = Grupo::create([
            'id_grupo' => $request->id_grupo,
            'nombre' => $request->nombre,
            'sigla' => $request->sigla,
            'id_gestion' => $request->id_gestion,
        ]);

        // ELIMINADO: Ya no usamos sync() aquí
        // $grupo->docentes()->sync($request->input('id_docentes'));

        // 3. CORRECCIÓN Bitácora:
        // Simplificamos el mensaje porque ya no tenemos los nombres de los docentes
        
        $materiaNombre = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $gestionNombre = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Creó el grupo '{$grupo->nombre}' (ID: {$grupo->id_grupo}) para la materia '{$materiaNombre}' en la gestión '{$gestionNombre}'",
        ]);
        
        // --- FIN CORRECCIÓN 'store' ---

        return redirect()->route('grupos.index')->with('success', 'Grupo creado.');
    }

    public function show(Grupo $grupo)
    {
        // Esto está bien, carga todas las relaciones para mostrar detalles
        $grupo->load('docentes.usuario', 'materia', 'gestionAcademica', 'asignacionesHorario.aula');
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $materias = Materia::all();
        $gestiones = GestionAcademica::all();
        
        // ELIMINADO: Ya no necesitamos 'docentes' ni 'docentesAsignados' para el formulario
        
        return view('grupos.edit', compact('grupo', 'materias', 'gestiones'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        // --- INICIO CORRECCIÓN 'update' ---
        
        // 1. Validamos los campos del formulario de edición
        $request->validate([
            // AGREGADO: Validamos el ID manual, asegurándonos que sea único
            // pero ignorando al grupo actual
            'id_grupo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('grupo', 'id_grupo')->ignore($grupo->id_grupo, 'id_grupo')
            ],
            'nombre' => 'required|string|max:30',
            // ELIMINADO: 'id_docentes' ya no se valida aquí
            'sigla' => 'required|exists:materia,sigla',
            'id_gestion' => 'required|exists:gestion_academica,id_gestion',
        ]);

        // Guardar valores antiguos para la bitácora
        $oldNombre = $grupo->nombre;
        $oldMateria = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $oldGestion = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;
        $oldId = $grupo->id_grupo;

        // 2. Actualizamos el grupo solo con sus datos
        $grupo->update([
            'id_grupo' => $request->id_grupo,
            'nombre' => $request->nombre,
            'sigla' => $request->sigla,
            'id_gestion' => $request->id_gestion,
        ]);

        // ELIMINADO: Ya no usamos sync() aquí
        // $grupo->docentes()->sync($request->input('id_docentes'));

        // 3. CORRECCIÓN Bitácora:
        // Simplificamos el mensaje
        
        $newMateria = $grupo->materia->nombre ?? 'Sigla ' . $grupo->sigla;
        $newGestion = $grupo->gestionAcademica->nombre ?? 'Gestión ' . $grupo->id_gestion;

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó el grupo de '{$oldNombre}' (ID: {$oldId}, Mat: {$oldMateria}, Gest: {$oldGestion})' a '{$grupo->nombre} (ID: {$grupo->id_grupo}, Mat: {$newMateria}, Gest: {$newGestion})'",
        ]);

        // --- FIN CORRECCIÓN 'update' ---

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado.');
    }

    public function destroy(Grupo $grupo)
    {
        try {
            // CORRECCIÓN Bitácora:
            // Quitamos la info de docentes que ya no está directamente en el grupo
            $nombre = $grupo->nombre;
            $materia = $grupo->materia->nombre ?? $grupo->sigla;

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó el grupo '{$nombre}' (ID: {$grupo->id_grupo}) de la materia '{$materia}'",
            ]);

            // Esto está bien. Borra las relaciones en la tabla pivote
            $grupo->docentes()->detach();
            
            // Borra las asignaciones de horario (si las tuviera)
            $grupo->asignacionesHorario()->delete(); 

            $grupo->delete();
            return redirect()->route('grupos.index')->with('success', 'Grupo eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Este catch es genérico, pero es mejor que el que tenías
            // porque la restricción podría ser por otra tabla, no solo horarios.
            return back()->with('error', 'No se puede eliminar el grupo porque tiene otros registros relacionados.');
        }
    }
}