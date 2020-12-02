<?php

namespace App\Bundles\Product\Providers;

use App\Based\Contracts\BundleProvider;

class ProductProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }
}
