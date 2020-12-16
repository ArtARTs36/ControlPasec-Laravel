<?php

namespace App\Bundles\Contragent\Providers;

use App\Based\Contracts\RouteServiceProvider;

class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Contragent\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
