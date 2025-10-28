<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Crear el Usuario base
            $usuario = Usuario::create([
                'email' => 'admin@sistema.com',
                'nombre' => 'Administrador General',
                'telefono' => '70012345',
                'password' => Hash::make('password'), // password
            ]);

            // Enlazarlo a la tabla Administrador
            $admin = new Administrador();
            $admin->id_usuario = $usuario->id_usuario;
            $admin->save();
        });
    }
}
