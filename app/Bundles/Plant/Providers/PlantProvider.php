<?php

namespace App\Bundles\Plant\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Plant\Contracts\PlantRepository;

final class PlantProvider extends BundleProvider
{
    public function register(): void
    {
        $this->app->singleton(
            PlantRepository::class,
            \App\Bundles\Plant\Repositories\PlantRepository::class
        );

        $this->app->register(RouteProvider::class);
    }
}
