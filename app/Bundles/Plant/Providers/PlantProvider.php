<?php

namespace App\Bundles\Plant\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Plant\Contracts\PlantRepository;
use ArtARTs36\LaravelWeather\Console\Commands\FetchWeatherCommand;

final class PlantProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories/';

    protected $commands = [
        FetchWeatherCommand::class,
    ];

    public function register(): void
    {
        $this->app->singleton(
            PlantRepository::class,
            \App\Bundles\Plant\Repositories\PlantRepository::class
        );

        $this->app->register(RouteProvider::class);

        $this->registerFactories();
        $this->registerCommands();
    }
}
