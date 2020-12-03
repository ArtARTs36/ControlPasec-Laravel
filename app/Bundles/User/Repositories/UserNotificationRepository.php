<?php

namespace App\Bundles\User\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\User\Models\UserNotification;
use Illuminate\Support\Facades\DB;

class UserNotificationRepository extends Repository
{
    public function create(array $usersIds, string $message, int $typeId, int $aboutModelId): bool
    {
        $data = [];

        foreach ($usersIds as $userId) {
            $data[] = [
                UserNotification::FIELD_IS_READ => false,
                UserNotification::FIELD_MESSAGE => $message,
                UserNotification::FIELD_TYPE_ID => $typeId,
                UserNotification::FIELD_ABOUT_MODEL_ID => $aboutModelId,
                UserNotification::FIELD_USER_ID => $userId,
            ];
        }

        return DB::table($this->model()->getTable())->insert($data);
    }
}
