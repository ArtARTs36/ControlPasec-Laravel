<?php

namespace App\Providers;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Listeners\ExternalManagerCreatedListener;
use App\Bundles\Document\Events\DocumentOfQueueGenerated;
use App\Based\Events\ExceptionNotified;
use App\Bundles\TechSupport\Events\ReportCreated;
use App\Listeners\DocumentOfQueueGenerateListener;
use App\Based\Listeners\ExceptionNotifiedListener;
use App\Bundles\TechSupport\Listeners\TechSupportReportCreatedListener;
use App\Listeners\TotemTaskUpdatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Studio\Totem\Events\Created as TotemTaskCreated;
use Studio\Totem\Events\Updated as TotemTaskUpdated;

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
        DocumentOfQueueGenerated::class => [
            DocumentOfQueueGenerateListener::class,
        ],
        ExceptionNotified::class => [
            ExceptionNotifiedListener::class,
        ],
        TotemTaskCreated::class => [
            TotemTaskUpdatedListener::class
        ],
        TotemTaskUpdated::class => [
            TotemTaskUpdatedListener::class,
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
