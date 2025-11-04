<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Bitacora;
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
        // 'capacidad' ELIMINADO DE LA VALIDACIÓN
        $request->validate([
            'id_aula' => 'required|numeric|unique:aula,id_aula',
            'tipo' => 'required|string|max:30',
        ]);

        $aula = Aula::create($request->all());

        // 'capacidad' ELIMINADO DE LA BITÁCORA
        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Creó el aula ID '{$aula->id_aula}' (Tipo: {$aula->tipo})",
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula creada exitosamente.');
    }

    public function show(Aula $aula)
    {
        return view('aulas.show', compact('aula'));
    }

    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        // 'capacidad' ELIMINADO DE LA VALIDACIÓN
        $request->validate([
            'tipo' => 'required|string|max:30',
        ]);

        $oldTipo = $aula->tipo;

        // 'capacidad' ELIMINADO DEL UPDATE
        $aula->update($request->only('tipo'));

        // 'capacidad' ELIMINADO DE LA BITÁCORA
        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó el aula ID '{$aula->id_aula}' (Tipo: {$oldTipo} -> {$aula->tipo})",
        ]);

        return redirect()->route('aulas.index')->with('success', 'Aula actualizada exitosamente.');
    }

    public function destroy(Aula $aula)
    {
        try {
            // 'capacidad' ELIMINADO DE LA BITÁCORA
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó el aula ID '{$aula->id_aula}' (Tipo: {$aula->tipo})",
            ]);

            $aula->delete();
            return redirect()->route('aulas.index')->with('success', 'Aula eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar, esta aula está en uso.');
        }
    }
}

