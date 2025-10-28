<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Bitacora; // ← Añadido
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', compact('aulas'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'capacidad' => 'required|integer|min:1',
            'tipo' => 'required|string|max:30',
        ]);

        $aula = Aula::create($request->all());

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Creó el aula de tipo '{$aula->tipo}' con capacidad para {$aula->capacidad} personas",
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula creada.');
    }

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'capacidad' => 'required|integer|min:1',
            'tipo' => 'required|string|max:30',
        ]);

        $oldTipo = $aula->tipo;
        $oldCapacidad = $aula->capacidad;

        $aula->update($request->all());

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó el aula de tipo '{$oldTipo}' (capacidad: {$oldCapacidad}) a tipo '{$aula->tipo}' (capacidad: {$aula->capacidad})",
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada.');
    }

    public function destroy(Aula $aula)
    {
        try {
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó el aula de tipo '{$aula->tipo}' con capacidad {$aula->capacidad}",
            ]);

            $aula->delete();
            return redirect()->route('aulas.index')->with('success', 'Aula eliminada.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar, esta aula está en uso.');
        }
    }
}
