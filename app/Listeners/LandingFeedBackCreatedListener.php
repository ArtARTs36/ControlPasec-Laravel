<?php

namespace App\Listeners;

use App\Bundles\Landing\Events\FeedBackCreated;
use App\Models\User\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class LandingFeedBackCreatedListener implements ShouldQueue
{
    /**
     * @param FeedBackCreated $event
     * @throws \Throwable
     */
    public function handle(FeedBackCreated $event): void
    {
        $message = view('messages/landing_feed_back_created', [
            'feedback' => $event->feedback
        ])->render();

        \app(PusherInterface::class)->push(
            new Push('Обратная связь: '. $event->feedback->id, $message)
        );

        UserNotificator::notify(UserNotificationType::LANDING_FEED_BACK_CREATED, $message, $event->feedback);
    }
}
