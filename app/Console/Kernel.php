<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\EnviarRecordatoriosClase::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Verifica recordatorios de clase cada minuto
        $schedule->command('notificaciones:recordatorios-clase')
                ->everyMinute()
                ->weekdays()
                ->between('6:00', '22:00');

        // Verifica asistencias pendientes cada día a las 22:00
        $schedule->command('notificaciones:asistencias-pendientes')
                ->dailyAt('22:00')
                ->weekdays();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}