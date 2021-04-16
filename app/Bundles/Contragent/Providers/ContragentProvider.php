<?php

namespace App\Bundles\Contragent\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Contragent\Contracts\ContragentFinder;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Observers\ContragentObserver;
use App\Bundles\Contragent\Support\DaDataAccessKey;
use App\Bundles\Contragent\Support\DaDataClient;
use App\Bundles\Contragent\Support\Finder;
use GuzzleHttp\Client;

final class ContragentProvider extends BundleProvider
{
    public $bindings = [
        ContragentFinder::class => Finder::class,
    ];

    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register(): void
    {
        $this->app->bind(DaDataAccessKey::class, function () {
            return new DaDataAccessKey(env('DADATA_ACCESS_KEY'));
        });

        $this->app->singleton(DaDataClient::class, function () {
            return new DaDataClient(new Client([
                'base_uri' => 'https://suggestions.dadata.ru/suggestions/api/4_1/',
            ]), $this->app->make(DaDataAccessKey::class));
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
