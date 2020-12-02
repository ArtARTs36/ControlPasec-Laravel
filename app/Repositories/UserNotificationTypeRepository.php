<?php

namespace App\Repositories;

use App\Models\User\UserNotificationType;

class UserNotificationTypeRepository
{
    public static function findByName(string $type): ?UserNotificationType
    {
        return UserNotificationType::query()
            ->with(UserNotificationType::RELATION_PERMISSION)
            ->where(UserNotificationType::FIELD_NAME, $type)
            ->first();
    }
}
