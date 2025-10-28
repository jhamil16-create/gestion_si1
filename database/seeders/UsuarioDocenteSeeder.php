<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Docente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioDocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $docente1 = Usuario::create([
                'email' => 'docente1@sistema.com',
                'nombre' => 'Juan Perez Garcia',
                'telefono' => '70054321',
                'password' => Hash::make('password'), // password
            ]);
            Docente::create(['id_usuario' => $docente1->id_usuario]);
        });

        DB::transaction(function () {
            $docente2 = Usuario::create([
                'email' => 'docente2@sistema.com',
                'nombre' => 'Maria Lopez Paz',
                'telefono' => '70011223',
                'password' => Hash::make('password'), // password
            ]);
            Docente::create(['id_usuario' => $docente2->id_usuario]);
        });
    }
}
