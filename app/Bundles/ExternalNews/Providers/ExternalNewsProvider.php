<?php

namespace App\Bundles\ExternalNews\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\ExternalNews\Console\ClearExternalNewsCommand;
use App\Bundles\ExternalNews\Console\GetExternalNewsCommand;
use App\Bundles\ExternalNews\Contracts\ExternalNewsRepository;
use App\Bundles\ExternalNews\Contracts\RssParser;
use App\Bundles\ExternalNews\Support\Rss;

final class ExternalNewsProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    protected $commands = [
        GetExternalNewsCommand::class,
        ClearExternalNewsCommand::class,
    ];

    public function register()
    {
        $this->app->register(ExternalNewsRouteProvider::class);

        $this->app->singleton(ExternalNewsRepository::class, \App\Bundles\ExternalNews\Repositories\ExternalNewsRepository::class);

        $this->app->singleton(RssParser::class, Rss::class);

        $this->registerFactories();

        $this->registerCommands();
    }
}
