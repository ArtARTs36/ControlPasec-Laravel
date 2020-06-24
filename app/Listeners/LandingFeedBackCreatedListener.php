<?php

namespace App\Listeners;

use App\Events\LandingFeedBackCreated;
use App\Models\User\UserNotificationType;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class LandingFeedBackCreatedListener implements ShouldQueue
{
    /**
     * @param LandingFeedBackCreated $event
     * @throws \Throwable
     */
    public function handle(LandingFeedBackCreated $event): void
    {
        $message = view('messages/landing_feed_back_created', [
            'feedback' => $event->feedback
        ])->render();

        (new Push('Обратная связь: '. $event->feedback->id, $message))->send();

        UserNotificator::notify(UserNotificationType::LANDING_FEED_BACK_CREATED, $message, $event->feedback);
    }
}
