<?php

namespace App\Bundles\Cron\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Cron\Contracts\Supervisor;
use App\Bundles\Cron\Supervisor\DockerSupervisor;
use App\Bundles\Cron\Supervisor\SelfSupervisor;

final class CronProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(EventProvider::class);

        $this->registerSupervisor();
    }

    protected function registerSupervisor(): void
    {
        $this->app->singleton(Supervisor::class, function () {
            $class = (env('RUN_IN_DOCKER') === true) ? DockerSupervisor::class : SelfSupervisor::class;

            return new $class();
        });
    }
}
