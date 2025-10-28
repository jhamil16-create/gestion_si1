<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    public function run(): void
    {
        Aula::create(['capacidad' => 50, 'tipo' => 'Teoría']); // ID: 1
        Aula::create(['capacidad' => 30, 'tipo' => 'Laboratorio']); // ID: 2
        Aula::create(['capacidad' => 50, 'tipo' => 'Teoría']); // ID: 3
    }
}
