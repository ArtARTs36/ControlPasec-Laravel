<?php

namespace App\Bundles\Cron\Providers;

use App\Based\Contracts\BundleProvider;

final class CronProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(EventProvider::class);
    }
}
