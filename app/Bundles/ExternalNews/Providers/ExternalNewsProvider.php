<?php

namespace App\Bundles\ExternalNews\Providers;

use App\Bundles\ExternalNews\Console\GetExternalNewsCommand;
use App\Bundles\ExternalNews\Contracts\ExternalNewsRepository;
use App\Bundles\ExternalNews\Contracts\RssParser;
use App\Bundles\ExternalNews\Support\Rss;
use Illuminate\Support\ServiceProvider;

class ExternalNewsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ExternalNewsRouteProvider::class);

        $this->app->singleton(ExternalNewsRepository::class, \App\Bundles\ExternalNews\Repositories\ExternalNewsRepository::class);

        $this->app->singleton(RssParser::class, Rss::class);

        $this->commands([
            GetExternalNewsCommand::class,
        ]);
    }
}
