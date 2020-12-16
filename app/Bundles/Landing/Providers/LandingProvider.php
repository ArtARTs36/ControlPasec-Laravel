<?php

namespace App\Bundles\Landing\Providers;

use App\Based\Contracts\BundleProvider;

class LandingProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->app->register(EventProvider::class);

        $this->registerFactories();
    }
}
