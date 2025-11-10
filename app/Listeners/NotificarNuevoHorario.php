<?php

namespace App\Listeners;

use App\Events\HorarioAsignado;
use App\Notifications\NuevoHorarioNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarNuevoHorario implements ShouldQueue
{
    public function handle(HorarioAsignado $event)
    {
        $docente = $event->asignacion->docente;
        $docente->notify(new NuevoHorarioNotification($event->asignacion));
    }
}