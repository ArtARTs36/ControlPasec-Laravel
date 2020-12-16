<?php

namespace App\Bundles\Document\Providers;

use App\Bundles\Document\Events\DocumentOfQueueGenerated;
use App\Bundles\Document\Listeners\DocumentOfQueueGenerateListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class EventProvider extends EventServiceProvider
{
    protected $listen = [
        DocumentOfQueueGenerated::class => [
            DocumentOfQueueGenerateListener::class,
        ],
    ];
}
