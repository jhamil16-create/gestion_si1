<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // El orden es MUY importante para que las llaves foráneas funcionen
        $this->call([
            // 1. Tablas sin dependencias
            GestionAcademicaSeeder::class,
            AulaSeeder::class,
            MateriaSeeder::class,

            // 2. Tablas de Usuarios (dependen de 'usuario')
            UsuarioAdminSeeder::class,
            UsuarioDocenteSeeder::class,

            // 3. Tablas que enlazan todo
            GrupoSeeder::class,
            AsignacionHorarioSeeder::class,

            // 4. Tablas de registros
            AsistenciaSeeder::class,
            BitacoraSeeder::class,
        ]);
    }
}
