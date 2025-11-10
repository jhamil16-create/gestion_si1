<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AulasExport;
use App\Exports\MateriasExport;
use App\Exports\DocentesExport;
use App\Exports\GruposExport;
use App\Imports\AulasImport;
use App\Imports\MateriasImport;
use App\Imports\DocentesImport;
use App\Imports\GruposImport;
use Maatwebsite\Excel\Facades\Excel;

class CatalogoController extends Controller
{
    /**
     * Muestra la página principal de gestión de catálogos.
     */
    public function index()
    {
        return view('catalogos.index');
    }

    /**
     * Exportar Aulas
     */
    public function exportarAulas() 
    {
        return Excel::download(new AulasExport, 'aulas.xlsx');
    }

    /**
     * Importar Aulas
     */
    public function importarAulas(Request $request)
    {
        $request->validate([
            'archivo_aulas' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new AulasImport, $request->file('archivo_aulas'));

        return back()->with('success', 'Aulas importadas correctamente.');
    }

    /**
     * Exportar Materias
     */
    public function exportarMaterias() 
    {
        return Excel::download(new MateriasExport, 'materias.xlsx');
    }

    /**
     * Importar Materias
     */
    public function importarMaterias(Request $request)
    {
        $request->validate([
            'archivo_materias' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new MateriasImport, $request->file('archivo_materias'));

        return back()->with('success', 'Materias importadas correctamente.');
    }

    /**
     * Exportar Docentes
     */
    public function exportarDocentes() 
    {
        return Excel::download(new DocentesExport, 'docentes.xlsx');
    }

    /**
     * Importar Docentes
     */
    public function importarDocentes(Request $request)
    {
        $request->validate([
            'archivo_docentes' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new DocentesImport, $request->file('archivo_docentes'));

        return back()->with('success', 'Docentes importadas correctamente.');
    }

    /**
     * Exportar Grupos
     */
    public function exportarGrupos() 
    {
        return Excel::download(new GruposExport, 'grupos.xlsx');
    }

    /**
     * Importar Grupos
     */
    public function importarGrupos(Request $request)
    {
        $request->validate([
            'archivo_grupos' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new GruposImport, $request->file('archivo_grupos'));

        return back()->with('success', 'Grupos importadas correctamente.');
    }
}