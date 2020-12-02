<?php

namespace App\Bundles\Landing\Http\Providers;

use App\Based\Contracts\RouteServiceProvider;

class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Landing\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Routes/api.php';
}
