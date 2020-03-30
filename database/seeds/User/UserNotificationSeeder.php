<?php

use App\Models\ModelType;
use App\Models\User\Permission;
use App\Models\User\UserNotificationType;

class UserNotificationSeeder extends CommonSeeder
{
    public function run(): void
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            Permission::class,
            'permission_name',
            'permission_id',
            'name'
        );

        $mapManager->add(
            ModelType::class,
            'about_model_class',
            'about_model_type_id',
            'class'
        );

        $this->fillModelWithMap(UserNotificationType::class, 'data_user_notification_types', $mapManager);
    }
}
