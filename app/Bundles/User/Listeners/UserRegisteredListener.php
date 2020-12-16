<?php

namespace App\Bundles\User\Listeners;

use App\Bundles\User\Events\UserRegistered;
use App\Bundles\User\Models\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Bundles\User\Support\UserMessageNotifier;
use Illuminate\Contracts\Queue\ShouldQueue;

final class UserRegisteredListener implements ShouldQueue
{
    private $pusher;

    private $userNotifier;

    public function __construct(PusherInterface $pusher, UserMessageNotifier $userNotifier)
    {
        $this->pusher = $pusher;
        $this->userNotifier = $userNotifier;
    }

    /**
     * @throws \Throwable
     */
    public function handle(UserRegistered $event): void
    {
        $message = view('messages/user_registered', [
            'user' => $event->user
        ])->render();

        $this->pusher->push(new Push('Заявка на регистрацию', $message));

        $this->userNotifier->notify(UserNotificationType::USER_REGISTERED, $message, $event->user);
    }
}
