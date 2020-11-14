<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserNotification;

class UserNotificationController extends Controller
{
    public function read(UserNotification $notification): UserNotification
    {
        return $notification->read();
    }
}
