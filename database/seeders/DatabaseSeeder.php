<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * Llama a los seeders en un orden lógico y comprueba si la clase existe
	 * antes de invocarla. Esto evita que `db:seed` falle si algún seeder
	 * todavía no está presente.
	 */
	public function run(): void
	{
		$seedersInOrder = [
			// Datos maestros (si existen)
			\Database\Seeders\MateriaSeeder::class,
			\Database\Seeders\AulaSeeder::class,
			\Database\Seeders\GestionAcademicaSeeder::class,

			// Usuarios (admins, docentes...)
			\Database\Seeders\UsuarioSeeder::class,

			// Entidades que dependen de usuarios y gestiones
			\Database\Seeders\GrupoSeeder::class,
			\Database\Seeders\AsignacionHorarioSeeder::class,
		];

		foreach ($seedersInOrder as $seederClass) {
			if (class_exists($seederClass)) {
				$this->call($seederClass);
				if (isset($this->command)) {
					$this->command->info("Seeded: {$seederClass}");
				}
			} else {
				if (isset($this->command)) {
					$this->command->info("Skipping seeder (no existe): {$seederClass}");
				}
			}
		}
	}
}