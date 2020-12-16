<?php

namespace App\Bundles\Landing\Providers;

use App\Bundles\Landing\Events\FeedBackCreated;
use App\Bundles\Landing\Listeners\FeedBackCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventProvider extends ServiceProvider
{
    protected $listen = [
        FeedBackCreated::class => [
            FeedBackCreatedListener::class,
        ],
    ];
}
