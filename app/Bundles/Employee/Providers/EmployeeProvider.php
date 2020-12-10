<?php

namespace App\Bundles\Employee\Providers;

use App\Based\Contracts\BundleProvider;

final class EmployeeProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories/';

    public function register()
    {
        $this->app->register(RouteProvider::class);

        $this->registerFactories();
    }
}
