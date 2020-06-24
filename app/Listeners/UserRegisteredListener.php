<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User\UserNotificationType;
use ArtARTs36\PushAllSender\Push;
use App\Support\UserNotificator;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param UserRegistered $event
     * @return void
     * @throws \Throwable
     */
    public function handle(UserRegistered $event): void
    {
        $message = view('messages/user_registered', [
            'user' => $event->user
        ])->render();

        (new Push('Заявка на регистрацию', $message))->send();

        UserNotificator::notify(UserNotificationType::USER_REGISTERED, $message, $event->user);
    }
}
