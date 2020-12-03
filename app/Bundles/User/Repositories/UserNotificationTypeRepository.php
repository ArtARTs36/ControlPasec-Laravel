<?php

namespace App\Bundles\User\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\User\Models\UserNotificationType;

class UserNotificationTypeRepository extends Repository
{
    public function findByName(string $type): ?UserNotificationType
    {
        return $this->newQuery()
            ->with(UserNotificationType::RELATION_PERMISSION)
            ->where(UserNotificationType::FIELD_NAME, $type)
            ->first();
    }
}
