<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AsignacionHorario;
use App\Events\ClaseProxima;
use Carbon\Carbon;

class EnviarRecordatoriosClase extends Command
{
    protected $signature = 'notificaciones:recordatorios-clase';
    protected $description = 'Envía recordatorios 30 minutos antes de cada clase';

    public function handle()
    {
        $ahora = Carbon::now();
        $en30Min = $ahora->copy()->addMinutes(30);

        // Buscar clases que empiezan en 30 minutos
        $asignaciones = AsignacionHorario::where('dia', strtolower($ahora->format('l')))
            ->whereRaw("TIME(hora_inicio) BETWEEN ? AND ?", [
                $en30Min->format('H:i:s'),
                $en30Min->copy()->addMinutes(1)->format('H:i:s')
            ])
            ->get();

        foreach ($asignaciones as $asignacion) {
            event(new ClaseProxima($asignacion));
        }

        $this->info("Se enviaron " . $asignaciones->count() . " recordatorios de clase.");
    }
}