<?php

namespace App\Bundles\Plant\Providers;

use App\Based\Contracts\RouteServiceProvider;

class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Plant\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
