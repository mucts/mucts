<?php

namespace App\Console;

use App\Console\Gjk\Family;
use App\Console\Gjk\PhysicalExamination;
use App\Console\Gjk\RealName;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Collection;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        RealName::class,
        Family::class,
        PhysicalExamination::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command("mcts:gjk:physical:examination")->dailyAt("00:00")->withoutOverlapping();

        /*Collection::times(20, function () use ($schedule) {
            $schedule->command("mcts:gjk:real:name:info")->everyMinute()->withoutOverlapping();
            $schedule->command("mcts:gjk:family:info")->everyMinute()->withoutOverlapping();
        });*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
