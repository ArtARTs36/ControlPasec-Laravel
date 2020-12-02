<?php

namespace App\Bundles\User\Providers;

use App\Based\Contracts\BundleProvider;

final class UserProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories/';

    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->registerFactories();
    }
}
