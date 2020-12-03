<?php

namespace App\Bundles\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Bundles\User\Models\UserNotification;

class UserNotificationController extends Controller
{
    public function read(UserNotification $notification): UserNotification
    {
        return $notification->read();
    }
}
