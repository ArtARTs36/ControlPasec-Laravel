<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User\UserNotification;
use App\Models\User\UserNotificationType;
use App\Senders\PushAllSender;
use App\Support\UserNotificator;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

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

        (new PushAllSender())->push('Заявка на регистрацию', $message);

        UserNotificator::notify(UserNotificationType::USER_REGISTERED, $message, $event->user);
    }
}
