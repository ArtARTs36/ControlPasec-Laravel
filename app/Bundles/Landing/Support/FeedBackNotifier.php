<?php

namespace App\Bundles\Landing\Support;

use App\Bundles\Landing\Models\FeedBack;
use App\Bundles\User\Models\UserNotificationType;
use App\Support\UserNotificator;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;

class FeedBackNotifier
{
    protected $pusher;

    public function __construct(PusherInterface $pusher)
    {
        $this->pusher = $pusher;
    }

    /**
     * @throws \ArtARTs36\PushAllSender\Exceptions\PushException
     * @throws \Throwable
     */
    public function notify(FeedBack $feedBack): void
    {
        $message = view('messages/landing_feed_back_created', [
            'feedback' => $feedBack,
        ])->render();

        $this->pusher->push(
            new Push('Обратная связь: '. $feedBack->id, $message)
        );

        UserNotificator::notify(UserNotificationType::LANDING_FEED_BACK_CREATED, $message, $feedBack);
    }
}
