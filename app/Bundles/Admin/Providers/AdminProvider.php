<?php

namespace App\Bundles\Admin\Providers;

use App\Based\Contracts\BundleProvider;

final class AdminProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register()
    {
        $this->app->register(RouteProvider::class);

        if ($this->app->runningInConsole()) {
            $this->registerFactories();
        }
    }
}
