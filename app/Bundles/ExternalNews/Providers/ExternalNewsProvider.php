<?php

namespace App\Bundles\ExternalNews\Providers;

use App\Console\Commands\CurrencyCourse\Clear;
use App\Console\Commands\GetUpdates;
use Illuminate\Support\ServiceProvider;

class ExternalNewsProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GetUpdates::class,
                Clear::class,
            ]);
        }
    }
}
