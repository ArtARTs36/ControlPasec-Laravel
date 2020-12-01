<?php

namespace App\Bundles\Vocab\Providers;

use App\Based\Contracts\RouteServiceProvider;

class VocabRouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Vocab\Http\Controllers';

    protected $routesApiFile = __DIR__ . '/../Http/Routes/api.php';
}
