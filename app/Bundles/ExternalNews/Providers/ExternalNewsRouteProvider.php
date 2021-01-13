<?php

namespace App\Bundles\ExternalNews\Providers;

use App\Based\Contracts\RouteServiceProvider;

final class ExternalNewsRouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\ExternalNews\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';

    protected $middlewares = ['api'];
}
