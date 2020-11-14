<?php

namespace App\Bundles\Contract\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class ContractRouteProvider extends RouteServiceProvider
{
    protected $namespace = 'App\Bundles\Contract\Http\Controllers';

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::namespace($this->namespace)
            ->prefix('api')
            ->group(__DIR__.'/../Http/routes/api.php');
    }
}
