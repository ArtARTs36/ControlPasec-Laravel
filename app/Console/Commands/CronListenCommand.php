<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Class CronListenCommand
 * @package App\Console\Commands
 */
class CronListenCommand extends Command
{
    private const MINUTE_MS = 1000000 * 30;

    protected $signature = 'cron:listen';

    protected $description = 'Schedule listen';

    public function handle(): void
    {
        while (true) {
            usleep(static::MINUTE_MS);

            Artisan::call('schedule:run');
        }
    }
}
