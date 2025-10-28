<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bitacora;
use App\Models\Usuario;

class BitacoraSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el admin
        $admin = Usuario::where('email', 'admin@sistema.com')->first();

        if ($admin) {
            Bitacora::create([
                'descripcion' => 'Ejecución de Seeders de Base de Datos',
                'ip_origen' => '127.0.0.1',
                'id_usuario' => $admin->id_usuario,
            ]);

            Bitacora::create([
                'descripcion' => 'Creación de 2 docentes de prueba.',
                'ip_origen' => '127.0.0.1',
                'id_usuario' => $admin->id_usuario,
            ]);
        }
    }
}
