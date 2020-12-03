<?php

namespace App\Bundles\Landing\Listeners;

use App\Bundles\Landing\Events\FeedBackCreated;
use App\Bundles\Landing\Support\FeedBackNotifier;
use App\Bundles\User\Models\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

final class FeedBackCreatedListener implements ShouldQueue
{
    private $notifier;

    public function __construct(FeedBackNotifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @param FeedBackCreated $event
     * @throws \Throwable
     */
    public function handle(FeedBackCreated $event): void
    {
        $this->notifier->notify($event->getFeedBack());
    }
}
