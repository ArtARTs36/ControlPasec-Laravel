<?php

namespace App\Bundles\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(UserRouteProvider::class);
    }
}
