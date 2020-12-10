<?php

namespace App\Bundles\Document\Providers;

use App\Based\Contracts\RouteServiceProvider;

final class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Document\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
