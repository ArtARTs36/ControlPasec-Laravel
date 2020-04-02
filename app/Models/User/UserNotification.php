<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class UserNotification
 * @property int $id
 * @property bool $is_read
 * @property string $message
 * @property int $user_id
 * @property User $user
 * @property UserNotificationType $type
 * @property int $type_id
 * @property int $about_model_id
 * @mixin Builder
 */
class UserNotification extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(UserNotificationType::class);
    }

    public function isRead(): bool
    {
        return $this->is_read === true;
    }

    public function isNotRead(): bool
    {
        return $this->is_read === false;
    }

    public function read(): self
    {
        $this->is_read = true;

        $this->save();

        return $this;
    }
}
