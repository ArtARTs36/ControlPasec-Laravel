<?php

namespace App\Bundles\User\Listeners;

use App\Bundles\User\Events\UserRegistered;
use App\Bundles\User\Models\UserNotificationType;
use ArtARTs36\PushAllSender\Interfaces\PusherInterface;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

final class UserRegisteredListener implements ShouldQueue
{
    private $pusher;

    public function __construct(PusherInterface $pusher)
    {
        $this->pusher = $pusher;
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

        UserNotificator::notify(UserNotificationType::USER_REGISTERED, $message, $event->user);
    }
}
