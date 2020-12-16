<?php

namespace App\Based\Providers;

use App\Based\Events\ExceptionNotified;
use App\Based\Listeners\ExceptionNotifiedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        ExceptionNotified::class => [
            ExceptionNotifiedListener::class,
        ],
    ];
}
