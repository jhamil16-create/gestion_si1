<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsignacionHorario;
use App\Models\Grupo;
use App\Models\Aula;

class AsignacionHorarioSeeder extends Seeder
{
    public function run(): void
    {
        $grupo1 = Grupo::find(1);
        $grupo2 = Grupo::find(2);
        $aula1 = Aula::find(1);
        $aula2 = Aula::find(2);

        if ($grupo1 && $aula1) {
            AsignacionHorario::create([
                'dia' => 'Lunes',
                'hora_inicio' => '08:00',
                'hora_fin' => '10:00',
                'id_aula' => $aula1->id_aula,
                'id_grupo' => $grupo1->id_grupo,
            ]); // ID: 1
        }
        
        if ($grupo1 && $aula1) {
            AsignacionHorario::create([
                'dia' => 'Miércoles',
                'hora_inicio' => '08:00',
                'hora_fin' => '10:00',
                'id_aula' => $aula1->id_aula,
                'id_grupo' => $grupo1->id_grupo,
            ]); // ID: 2
        }

        if ($grupo2 && $aula2) {
            AsignacionHorario::create([
                'dia' => 'Martes',
                'hora_inicio' => '10:00',
                'hora_fin' => '12:00',
                'id_aula' => $aula2->id_aula,
                'id_grupo' => $grupo2->id_grupo,
            ]); // ID: 3
        }
    }
}
