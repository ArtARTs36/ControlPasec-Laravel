<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class UserNotificationType
 * @property int $id
 * @property string $name
 * @property string $title
 * @property Permission $permission
 * @mixin Builder
 */
class UserNotificationType extends Model
{
    const USER_REGISTERED = 'user_registered';
    const LANDING_FEED_BACK_CREATED = 'landing_feed_back_created';
    const TECH_SUPPORT_REPORT_CREATED = 'tech_support_report_created';

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
