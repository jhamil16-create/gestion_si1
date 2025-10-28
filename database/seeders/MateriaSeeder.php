<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        Materia::create([
            'sigla' => 'SIS-101',
            'nombre' => 'Introducción a la Informática',
        ]);
        Materia::create([
            'sigla' => 'SIS-102',
            'nombre' => 'Programación I',
        ]);
        Materia::create([
            'sigla' => 'SIS-201',
            'nombre' => 'Estructura de Datos',
        ]);
    }
}
