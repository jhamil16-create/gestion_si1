<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\AsignacionHorario;

class RecordatorioClaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $asignacion;

    public function __construct(AsignacionHorario $asignacion)
    {
        $this->asignacion = $asignacion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'recordatorio_clase',
            'title' => 'Recordatorio de Clase',
            'icon' => 'fa-bell',
            'color' => 'yellow',
            'message' => "Tienes clase de {$this->asignacion->grupo->materia->nombre} en 30 minutos",
            'action_url' => route('horario.docente'),
            'action_text' => 'Ver Detalles',
            'grupo_id' => $this->asignacion->id_grupo,
            'aula_id' => $this->asignacion->id_aula,
            'hora_inicio' => $this->asignacion->hora_inicio,
        ];
    }
}