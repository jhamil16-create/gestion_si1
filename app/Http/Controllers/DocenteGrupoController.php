<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importante para la validación
use Illuminate\Validation\Rule;

class DocenteGrupoController extends Controller
{
    /**
     * Muestra el formulario para asignar un docente a un grupo.
     */
    public function create()
    {
        // Pasamos todos los docentes y todas las materias a la vista
        $docentes = Docente::with('usuario')->get();
        $materias = Materia::orderBy('nombre')->get();
        
        return view('docente_grupo.create', compact('docentes', 'materias'));
    }

    /**
     * Guarda la asignación en la tabla pivote (docente_grupo).
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'id_docente' => 'required|exists:docente,id_docente',
            'id_grupo' => 'required|exists:grupo,id_grupo',
            // Agregamos una validación para asegurar que este docente
            // no esté ya asignado a este grupo.
            'id_grupo' => Rule::unique('docente_grupo')->where(function ($query) use ($request) {
                return $query->where('id_docente', $request->id_docente);
            }),
        ], [
            // Mensaje de error personalizado
            'id_grupo.unique' => 'Este docente ya está asignado a este grupo.'
        ]);

        // 2. Buscamos al docente
        $docente = Docente::find($request->id_docente);

        // 3. Usamos attach() para agregar la relación en la tabla pivote
        // sin borrar las que ya tenía.
        $docente->grupos()->attach($request->id_grupo);

        // 4. Redirigimos a la vista de "Detalles del Docente"
        // para que puedas ver la asignación que acabas de hacer.
        return redirect()->route('docentes.show', $request->id_docente)
                         ->with('success', 'Docente asignado al grupo exitosamente.');
    }

    /**
     * API: Devuelve una lista de grupos (en JSON) 
     * que pertenecen a una materia específica.
     */
    public function getGruposPorMateria(Request $request)
    {
        // Validamos que nos estén pasando la sigla
        $request->validate(['sigla' => 'required|exists:materia,sigla']);

        // Buscamos los grupos que coincidan con esa sigla
        $grupos = Grupo::where('sigla', $request->sigla)
                       ->orderBy('nombre')
                       ->get();
                       
        // Devolvemos los grupos como JSON
        return response()->json($grupos);
    }
}