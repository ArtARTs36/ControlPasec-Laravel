<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Senders\PushAllSender;
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
    public function handle(UserRegistered $event)
    {
        $sender = new PushAllSender();

        $message = view('messages/user_registered', [
            'user' => $event->user
        ])->render();

        $sender->push('Заявка на регистрацию', $message);
    }
}
