<?php

namespace App\Bundles\User\Providers;

use App\Based\Contracts\RouteServiceProvider;

class UserRouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\User\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
