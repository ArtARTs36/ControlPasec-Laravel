<?php

namespace App\Bundles\Landing\Support;

use App\Bundles\Landing\Models\FeedBack;
use App\Bundles\User\Models\UserNotificationType;
use App\Bundles\User\Support\UserMessageNotifier;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;

class FeedBackNotifier
{
    protected $pusher;

    protected $userNotifier;

    public function __construct(PusherInterface $pusher, UserMessageNotifier $userNotifier)
    {
        $this->pusher = $pusher;
        $this->userNotifier = $userNotifier;
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

        $this->userNotifier->notify(UserNotificationType::LANDING_FEED_BACK_CREATED, $message, $feedBack);
    }
}
