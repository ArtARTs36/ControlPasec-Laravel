<?php

namespace App\Bundles\User\Providers;

use App\Bundles\User\Events\UserRegistered;
use App\Bundles\User\Listeners\UserRegisteredListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class EventProvider extends EventServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
            UserRegisteredListener::class,
        ],
    ];
}
