<?php

namespace App\Bundles\Product\Providers;

use App\Based\Contracts\RouteServiceProvider;

final class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Product\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
