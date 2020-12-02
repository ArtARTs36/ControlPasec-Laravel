<?php

namespace App\Bundles\User\Providers;

use App\Based\Contracts\BundleProvider;

final class UserProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }
}
