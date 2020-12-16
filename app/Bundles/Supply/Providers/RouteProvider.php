<?php

namespace App\Bundles\Supply\Providers;

use App\Based\Contracts\RouteServiceProvider;

class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Supply\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
