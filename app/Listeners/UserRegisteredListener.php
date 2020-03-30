<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User\UserNotification;
use App\Models\User\UserNotificationType;
use App\Senders\PushAllSender;
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
    public function handle(UserRegistered $event)
    {
        $sender = new PushAllSender();

        $message = view('messages/user_registered', [
            'user' => $event->user
        ])->render();

        $sender->push('Заявка на регистрацию', $message);

        $this->createUserNotifications($message, $event->user);
    }

    private function createUserNotifications(string $message, User $aboutUser)
    {
        $type = UserNotificationType::where('name', UserNotificationType::USER_REGISTERED)
            ->first();

        /** @var User[] $users */
        $users = $type->permission
            ->getUsers();

        foreach ($users as $user) {
            $notification = new UserNotification();
            $notification->is_read = false;
            $notification->user_id = $user->id;
            $notification->message = $message;
            $notification->type_id = $type->id;
            $notification->about_model_id = $aboutUser->id;

            $notification->save();
        }
    }
}
