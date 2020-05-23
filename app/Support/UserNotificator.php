<?php

namespace App\Support;

use App\Models\User\UserNotification;
use App\Models\User\UserNotificationType;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserNotificator
{
    public static function notify(string $type, string $message, Model $aboutModel): void
    {
        $type = UserNotificationType::query()
            ->with(UserNotificationType::RELATION_PERMISSION)
            ->where(UserNotificationType::FIELD_NAME, $type)
            ->first();

        /** @var User[] $users */
        $users = $type->permission->getUsers();

        foreach ($users as $user) {
            $notification = new UserNotification();
            $notification->is_read = false;
            $notification->user_id = $user->id;
            $notification->message = $message;
            $notification->type_id = $type->id;
            $notification->about_model_id = $aboutModel->id;

            $notification->save();
        }
    }
}
