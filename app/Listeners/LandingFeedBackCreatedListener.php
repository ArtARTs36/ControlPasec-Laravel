<?php

namespace App\Listeners;

use App\Events\LandingFeedBackCreated;
use App\Models\User\UserNotificationType;
use App\Senders\PushAllSender;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class LandingFeedBackCreatedListener implements ShouldQueue
{
    public function handle(LandingFeedBackCreated $event)
    {
        $sender = new PushAllSender();

        $message = view('messages/landing_feed_back_created', [
            'feedback' => $event->feedback
        ])->render();

        $sender->push('Обратная связь: '. $event->feedback->id, $message);

        UserNotificator::notify(UserNotificationType::LANDING_FEED_BACK_CREATED, $message, $event->feedback);
    }
}
