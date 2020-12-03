<?php

namespace App\Based\Listeners;

use App\Based\Events\ExceptionNotified;
use App\Based\Support\ExceptionNotifier;

final class ExceptionNotifiedListener
{
    private $notifier;

    public function __construct(ExceptionNotifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @throws \ArtARTs36\PushAllSender\Exceptions\PushException
     */
    public function handle(ExceptionNotified $event): void
    {
        $this->notifier->notify($event->getException());
    }
}
