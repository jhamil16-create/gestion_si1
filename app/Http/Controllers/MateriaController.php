<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Bitacora; // ← Importa el modelo Bitacora
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as FacadeRequest; // Para obtener la IP

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sigla' => 'required|string|max:10|unique:materia,sigla',
            'nombre' => 'required|string|max:100',
        ]);
        
        $materia = Materia::create($request->all());

        // Registrar en bitácora
        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen'  => $request->ip(),
            'descripcion' => "Creó la materia '{$materia->nombre}' (Sigla: {$materia->sigla})",
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia creada.');
    }

    public function show(Materia $materia)
    {
        $materia->load('grupos.docente.usuario');
        return view('materias.show', compact('materia'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'sigla' => [
                'required',
                'string',
                'max:10',
                Rule::unique('materia', 'sigla')->ignore($materia->sigla, 'sigla')
            ],
            'nombre' => 'required|string|max:100',
        ]);
        
        $oldSigla = $materia->sigla;
        $oldNombre = $materia->nombre;

        $materia->update($request->all());

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen'  => $request->ip(),
            'descripcion' => "Actualizó la materia de '{$oldNombre} ({$oldSigla})' a '{$materia->nombre} ({$materia->sigla})'",
        ]);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada.');
    }

    public function destroy(Materia $materia)
    {
        try {
            $nombre = $materia->nombre;
            $sigla = $materia->sigla;

            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen'  => $request->ip(),
                'descripcion' => "Eliminó la materia '{$nombre}' (Sigla: {$sigla})",
            ]);

            $materia->delete();
            return redirect()->route('materias.index')->with('success', 'Materia eliminada.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar la materia, está siendo utilizada por uno o más grupos.');
        }
    }
}
