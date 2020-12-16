<?php

namespace App\Bundles\Employee\Providers;

use App\Based\Contracts\RouteServiceProvider;

final class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Employee\Http';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
