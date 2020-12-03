<?php

namespace App\Providers;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Listeners\ExternalManagerCreatedListener;
use App\Events\DocumentOfQueueGenerated;
use App\Events\ExceptionNotified;
use App\Bundles\Landing\Events\FeedBackCreated;
use App\Events\TechSupportReportCreated;
use App\Bundles\User\Events\UserRegistered;
use App\Listeners\DocumentOfQueueGenerateListener;
use App\Listeners\ExceptionNotifiedListener;
use App\Listeners\LandingFeedBackCreatedListener;
use App\Bundles\TechSupport\Listeners\TechSupportReportCreatedListener;
use App\Listeners\TotemTaskUpdatedListener;
use App\Listeners\UserRegisteredListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
            UserRegisteredListener::class,
        ],
        FeedBackCreated::class => [
            LandingFeedBackCreatedListener::class,
        ],
        TechSupportReportCreated::class => [
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
