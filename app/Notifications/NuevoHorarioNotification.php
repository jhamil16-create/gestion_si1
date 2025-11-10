<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\AsignacionHorario;

class NuevoHorarioNotification extends Notification implements ShouldQueue
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
            'type' => 'nuevo_horario',
            'title' => 'Nuevo Horario Asignado',
            'icon' => 'fa-calendar-plus',
            'color' => 'blue',
            'message' => "Se te ha asignado un nuevo horario para {$this->asignacion->grupo->materia->nombre}",
            'action_url' => route('horario.docente'),
            'action_text' => 'Ver Horario',
            'grupo_id' => $this->asignacion->id_grupo,
            'materia_id' => $this->asignacion->grupo->sigla,
            'aula_id' => $this->asignacion->id_aula,
            'dia' => $this->asignacion->dia,
            'hora_inicio' => $this->asignacion->hora_inicio,
            'hora_fin' => $this->asignacion->hora_fin,
        ];
    }
}