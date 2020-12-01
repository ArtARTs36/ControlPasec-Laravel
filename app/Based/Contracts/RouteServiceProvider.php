<?php

namespace App\Based\Contracts;

use Illuminate\Support\Facades\Route;

abstract class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    protected const PREFIX_API = 'api';

    protected $namespace;

    protected $routesApiFile;

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix(static::PREFIX_API)
            ->middleware('api')
            ->namespace($this->namespace)
            ->group($this->routesApiFile);
    }

    protected function mapWebRoutes(): void
    {
        //
    }
}
