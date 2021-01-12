<?php

namespace App\Bundles\Product\Providers;

use App\Based\Contracts\BundleProvider;

final class ProductProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register()
    {
        $this->app->register(RouteProvider::class);

        $this->registerFactories();
    }
}
