<?php

namespace App\Bundles\Landing\Providers;

use App\Based\Contracts\BundleProvider;

class LandingProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }
}
