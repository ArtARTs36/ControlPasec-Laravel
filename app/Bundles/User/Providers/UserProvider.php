<?php

namespace App\Bundles\User\Providers;

use App\Based\Contracts\BundleProvider;
use App\Bundles\User\Contracts\Tokenizer;
use App\Bundles\User\Services\Auth\Jwt;

final class UserProvider extends BundleProvider
{
    protected $factoriesPath = __DIR__ . '/../Database/Factories/';

    public function register()
    {
        $this->app->register(RouteProvider::class);
        $this->app->register(EventProvider::class);
        $this->registerFactories();

        $this->app->bind(Tokenizer::class, Jwt::class);
    }
}
