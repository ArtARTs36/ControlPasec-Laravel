<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class UserNotificationType
 * @property int id
 * @property string name
 * @property string title
 * @property Permission permission
 * @mixin Builder
 */
class UserNotificationType extends Model
{
    const USER_REGISTERED = 'user_registered';

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
