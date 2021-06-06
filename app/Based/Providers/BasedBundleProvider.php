<?php

namespace App\Based\Providers;

use App\Based\Contracts\BundleProvider;
use ArtARTs36\LaravelHoliday\Console\FetchHolidays;

class BasedBundleProvider extends BundleProvider
{
    protected $commands = [
        FetchHolidays::class,
    ];

    public function register()
    {
        $this->registerCommands();
    }
}
