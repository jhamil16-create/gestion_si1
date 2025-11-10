<?php

namespace App\Listeners;

use App\Events\ClaseProxima;
use App\Notifications\RecordatorioClaseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificarRecordatorioClase implements ShouldQueue
{
    public function handle(ClaseProxima $event)
    {
        $docente = $event->asignacion->docente;
        $docente->notify(new RecordatorioClaseNotification($event->asignacion));
    }
}