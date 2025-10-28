<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GestionAcademica;

class GestionAcademicaSeeder extends Seeder
{
    public function run(): void
    {
        GestionAcademica::create([
            'nombre' => '1-2025',
            'fecha_inicio' => '2025-02-01',
            'fecha_fin' => '2025-06-30',
        ]);

        GestionAcademica::create([
            'nombre' => '2-2025',
            'fecha_inicio' => '2025-08-01',
            'fecha_fin' => '2025-12-31',
        ]);
    }
}
