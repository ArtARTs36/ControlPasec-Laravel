<?php

namespace App\Bundles\Admin\Providers;

use App\Based\Contracts\RouteServiceProvider;

final class RouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Admin\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
