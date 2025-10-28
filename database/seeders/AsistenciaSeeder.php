<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asistencia;
use App\Models\AsignacionHorario;

class AsistenciaSeeder extends Seeder
{
    public function run(): void
    {
        $asignacion1 = AsignacionHorario::find(1); // Lunes 08:00

        if ($asignacion1) {
            // Asumiendo que la gestión empezó en Feb 2025
            Asistencia::create([
                'fecha' => '2025-02-10', // Un lunes
                'estado' => 'P',
                'observaciones' => 'Avance tema 1',
                'id_asignacion' => $asignacion1->id_asignacion,
            ]);

            Asistencia::create([
                'fecha' => '2025-02-17', // Siguiente lunes
                'estado' => 'F',
                'observaciones' => 'Feriado de carnaval',
                'id_asignacion' => $asignacion1->id_asignacion,
            ]);
            
            Asistencia::create([
                'fecha' => '2025-02-24',
                'estado' => 'P',
                'observaciones' => 'Avance tema 2',
                'id_asignacion' => $asignacion1->id_asignacion,
            ]);
        }
    }
}
