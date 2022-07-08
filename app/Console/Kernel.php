<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $command = [
        'App\Console\Commands\DevicesCommand'
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('devices:status')->dailyAt('18:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
