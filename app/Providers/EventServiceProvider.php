<?php

namespace App\Providers;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Listeners\ExternalManagerCreatedListener;
use App\Based\Events\ExceptionNotified;
use App\Bundles\TechSupport\Events\ReportCreated;
use App\Based\Listeners\ExceptionNotifiedListener;
use App\Bundles\TechSupport\Listeners\TechSupportReportCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ReportCreated::class => [
            TechSupportReportCreatedListener::class,
        ],
        ExceptionNotified::class => [
            ExceptionNotifiedListener::class,
        ],
        ExternalManagerCreated::class => [
            ExternalManagerCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
