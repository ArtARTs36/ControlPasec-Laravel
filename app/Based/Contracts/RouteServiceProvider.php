<?php

namespace App\Based\Contracts;

use Illuminate\Support\Facades\Route;

abstract class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    protected $routesApiFile;

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group($this->routesApiFile);
    }
}
