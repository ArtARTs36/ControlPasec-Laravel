<?php

namespace App\Based\Providers;

use App\Based\Contracts\BundleProvider;
use ArtARTs36\LaravelBlockIp\Console\Commands\GetNewIps;
use ArtARTs36\LaravelHoliday\Console\FetchHolidays;

class BasedBundleProvider extends BundleProvider
{
    protected $commands = [
        FetchHolidays::class,
        GetNewIps::class,
    ];

    public function register()
    {
        $this->registerCommands();
    }
}
