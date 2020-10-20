<?php

namespace App\Bundles\Contract\Providers;

use App\Bundles\Contract\Contracts\ContractRepository;
use Illuminate\Support\ServiceProvider;
use App\Bundles\Contract\Repositories\ContractRepository as ContractRepositoryImplementation;

class ContractProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ContractRepository::class, ContractRepositoryImplementation::class);

        $this->app->register(ContractRouteProvider::class);
    }
}
