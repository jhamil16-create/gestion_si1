<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Administrador;
use App\Models\Docente;
use Illuminate\Support\Facades\DB; // ¡Importante para la transacción!

// El nombre de la clase lo dejamos como UsuarioSeeder (singular)
// para que coincida con el nombre del archivo.
class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Este seeder crea los 2 Admins (mínimo) y los Docentes.
     * Usa firstOrCreate para evitar duplicados si se corre varias veces.
     */
    public function run(): void
    {
        // Usamos una transacción. Si algo falla (ej: al crear Admin),
        // se deshace la creación del Usuario.
        DB::transaction(function () {
            
            // --- Administradores ---
            // (Cumplen la regla de "mínimo 2")
            $admins = [
                [
                    'email' => 'admin@sistema.com',
                    'password' => Hash::make('admin123'),
                    'nombre' => 'Juan Pérez',
                    'telefono' => '12345678',
                ],
                [
                    'email' => 'admin2@sistema.com',
                    'password' => Hash::make('admin123'),
                    'nombre' => 'Ana García',
                    'telefono' => '87654321',
                ],
            ];

            foreach ($admins as $adminData) {
                // 1. Busca por email. Si no existe, lo crea con TODOS los datos.
                $usuario = Usuario::firstOrCreate(
                    ['email' => $adminData['email']], // Campo de búsqueda
                    $adminData                       // Datos para crear si no existe
                );

                // 2. Vincula el usuario a la tabla Administrador
                Administrador::firstOrCreate(
                    ['id_usuario' => $usuario->id_usuario]
                );
            }

            // --- Docentes ---
            $docentes = [
                [
                    'email' => 'docente1@sistema.com',
                    'password' => Hash::make('docente123'),
                    'nombre' => 'Carlos Ruiz',
                    'telefono' => '11111111',
                ],
                [
                    'email' => 'docente2@sistema.com',
                    'password' => Hash::make('docente123'),
                    'nombre' => 'Laura Martínez',
                    'telefono' => '22222222',
                ],
            ];

            foreach ($docentes as $docenteData) {
                // 1. Busca por email. Si no existe, lo crea.
                $usuario = Usuario::firstOrCreate(
                    ['email' => $docenteData['email']],
                    $docenteData
                );

                // 2. Vincula el usuario a la tabla Docente
                Docente::firstOrCreate(
                    ['id_usuario' => $usuario->id_usuario]
                );
            }

        }); // Fin de la transacción

        $this->command->info('Administradores y Docentes creados/verificados exitosamente.');
    }
}