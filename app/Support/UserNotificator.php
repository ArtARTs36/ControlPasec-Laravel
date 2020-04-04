<?php

namespace App\Support;

use App\Models\User\UserNotification;
use App\Models\User\UserNotificationType;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserNotificator
{
    public static function create(string $type, string $message, Model $aboutModel)
    {
        $type = UserNotificationType::where('name', $type)
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
            $notification->about_model_id = $aboutModel->id;

            $notification->save();
        }
    }
}
