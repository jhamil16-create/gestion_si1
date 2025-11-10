<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AsistenciaPendienteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $grupo;
    protected $fecha;

    public function __construct($grupo, $fecha)
    {
        $this->grupo = $grupo;
        $this->fecha = $fecha;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'asistencia_pendiente',
            'title' => 'Asistencia Pendiente',
            'icon' => 'fa-clipboard-check',
            'color' => 'red',
            'message' => "No has registrado la asistencia para {$this->grupo->materia->nombre} del {$this->fecha}",
            'action_url' => route('asistencias.registrar'),
            'action_text' => 'Registrar Asistencia',
            'grupo_id' => $this->grupo->id_grupo,
            'fecha' => $this->fecha,
        ];
    }
}