<?php

namespace App\Based\Console;

use App\Based\Console\Commands\CompileFontFromDompdfCommand;
use App\Bundles\ExternalNews\Console\GetExternalNewsCommand;
use App\Bundles\Vocab\Console\GetCurrencyCourseCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CompileFontFromDompdfCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(GetCurrencyCourseCommand::class)
            ->dailyAt('12:00')
            ->dailyAt('18:00');

        $schedule->command(GetExternalNewsCommand::class)
            ->dailyAt('12:00')
            ->dailyAt('20:00');
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
