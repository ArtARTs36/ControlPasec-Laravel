<?php

namespace App\Bundles\Supply\Providers;

use App\Based\Providers\EventServiceProvider;
use App\Bundles\Supply\Events\SupplyCreated;
use App\Bundles\Supply\Handlers\CreateTransitionForNewSupply;

class EventProvider extends EventServiceProvider
{
    protected $listen = [
        SupplyCreated::class => [
            CreateTransitionForNewSupply::class,
        ],
    ];
}
