<?php

namespace App\Http\Controllers;

use App\Models\GestionAcademica;
use App\Models\Bitacora; // ← Añadido
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GestionAcademicaController extends Controller
{
    public function index()
    {
        $gestiones = GestionAcademica::all();
        return view('gestiones.index', compact('gestiones'));
    }

    public function create()
    {
        return view('gestiones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:30|unique:gestion_academica,nombre',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $gestion = GestionAcademica::create($request->all());

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Creó la gestión académica '{$gestion->nombre}' ({$gestion->fecha_inicio} a {$gestion->fecha_fin})",
        ]);

        return redirect()->route('gestiones.index')->with('success', 'Gestión creada.');
    }

    public function edit(GestionAcademica $gestione)
    {
        return view('gestiones.edit', compact('gestione'));
    }

    public function update(Request $request, GestionAcademica $gestione)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:30',
                Rule::unique('gestion_academica', 'nombre')->ignore($gestione->id_gestion, 'id_gestion')
            ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $oldNombre = $gestione->nombre;
        $oldInicio = $gestione->fecha_inicio;
        $oldFin = $gestione->fecha_fin;

        $gestione->update($request->all());

        Bitacora::create([
            'id_usuario' => auth()->id(),
            'ip_origen' => $request->ip(),
            'descripcion' => "Actualizó la gestión de '{$oldNombre} ({$oldInicio}–{$oldFin})' a '{$gestione->nombre} ({$gestione->fecha_inicio}–{$gestione->fecha_fin})'",
        ]);

        return redirect()->route('gestiones.index')->with('success', 'Gestión actualizada.');
    }

    public function destroy(GestionAcademica $gestione)
    {
        try {
            Bitacora::create([
                'id_usuario' => auth()->id(),
                'ip_origen' => request()->ip(),
                'descripcion' => "Eliminó la gestión académica '{$gestione->nombre}' ({$gestione->fecha_inicio}–{$gestione->fecha_fin})",
            ]);

            $gestione->delete();
            return redirect()->route('gestiones.index')->with('success', 'Gestión eliminada.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'No se puede eliminar, esta gestión está en uso.');
        }
    }
}
