<?php

namespace App\Bundles\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(AdminRouteProvider::class);
    }
}
