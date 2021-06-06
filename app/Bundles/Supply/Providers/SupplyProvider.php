<?php

namespace App\Bundles\Supply\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\Supply\Contracts\Creator;
use App\Bundles\Supply\Services\SupplyCreateOptions\CreateScoreForPayment;
use App\Bundles\Supply\Services\SupplyCreator;

class SupplyProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories';

    public function register()
    {
        $this->app->bind(Creator::class, function () {
            return new SupplyCreator($this->getInstances([
                CreateScoreForPayment::OPTION_NAME => CreateScoreForPayment::class,
            ]));
        });

        $this->app->register(RouteProvider::class);
        $this->app->register(EventProvider::class);

        $this->registerFactories();
    }
}
