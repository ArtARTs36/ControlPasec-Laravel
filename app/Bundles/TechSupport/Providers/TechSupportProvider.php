<?php

namespace App\Bundles\TechSupport\Providers;

use Illuminate\Support\ServiceProvider;

class TechSupportProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->app->register(EventProvider::class);
    }
}
