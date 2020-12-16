<?php

namespace App\Bundles\TechSupport\Providers;

use App\Based\Contracts\RouteServiceProvider;

class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\TechSupport\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
