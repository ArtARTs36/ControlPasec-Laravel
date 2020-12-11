<?php

namespace App\Bundles\Contragent\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Observers\ContragentObserver;
use App\Bundles\Contragent\Support\DaDataClient;
use GuzzleHttp\Client;

final class ContragentProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register(): void
    {
        $this->app->singleton(DaDataClient::class, function () {
            return new DaDataClient(new Client([
                'base_uri' => 'https://suggestions.dadata.ru/suggestions/api/4_1/',
            ]), 'bd0f0bb6afa265cda47baacbdb7bdd4c077ffc64');
        });

        $this->app->register(RouteProvider::class);
        $this->app->register(EventProvider::class);

        $this->registerFactories();
    }

    public function boot(): void
    {
        Contragent::observe(ContragentObserver::class);
    }
}
