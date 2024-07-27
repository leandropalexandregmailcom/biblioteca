<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Defina os comandos fornecidos pelo aplicativo.
     *
     * @var array
     */
    protected $commands = [
        // Registre os comandos aqui
    ];

    /**
     * Defina a programação de tarefas.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Agendamento de tarefas
        $schedule->command('inspire')->hourly();
        $schedule->command('emails:send')->daily();
    }

    /**
     * Registre os eventos de comando do aplicativo.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
