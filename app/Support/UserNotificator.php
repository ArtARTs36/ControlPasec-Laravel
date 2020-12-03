<?php

namespace App\Support;

use App\Bundles\User\Models\UserNotification;
use App\Repositories\UserNotificationTypeRepository;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserNotificator
{
    public static function notify(string $type, string $message, Model $aboutModel): void
    {
        $type = UserNotificationTypeRepository::findByName($type);

        if ($type === null) {
            throw new \LogicException('Не верно задан тип уведомления!');
        }

        foreach ($type->permission->getUsers() as $user) {
            $notification = new UserNotification();
            $notification->user_id = $user->id;
            $notification->message = $message;
            $notification->type_id = $type->id;
            $notification->about_model_id = $aboutModel->id;

            $notification->save();
        }
    }
}
