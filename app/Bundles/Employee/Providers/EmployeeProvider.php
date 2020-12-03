<?php

namespace App\Bundles\Employee\Providers;

use App\Based\Contracts\BundleProvider;

final class EmployeeProvider extends BundleProvider
{
    public function register()
    {
        $this->app->register(RouteProvider::class);
    }
}
