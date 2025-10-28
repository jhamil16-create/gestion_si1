<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\GestionAcademica;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener los datos creados por los otros seeders
        $docente1 = Docente::whereHas('usuario', fn($q) => $q->where('email', 'docente1@sistema.com'))->first();
        $docente2 = Docente::whereHas('usuario', fn($q) => $q->where('email', 'docente2@sistema.com'))->first();
        
        $materia1 = Materia::where('sigla', 'SIS-101')->first();
        $materia2 = Materia::where('sigla', 'SIS-102')->first();

        $gestion = GestionAcademica::where('nombre', '1-2025')->first();

        // Crear Grupos
        if ($docente1 && $materia1 && $gestion) {
            Grupo::create([
                'nombre' => 'SA',
                'capacidad' => 50,
                'id_docente' => $docente1->id_docente,
                'sigla' => $materia1->sigla,
                'id_gestion' => $gestion->id_gestion,
            ]); // ID: 1
        }
        
        if ($docente2 && $materia2 && $gestion) {
            Grupo::create([
                'nombre' => 'SB',
                'capacidad' => 50,
                'id_docente' => $docente2->id_docente,
                'sigla' => $materia2->sigla,
                'id_gestion' => $gestion->id_gestion,
            ]); // ID: 2
        }
    }
}
