<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    public const RELATION_TYPE = 'type';

    public const FIELD_IS_READ = 'is_read';
    public const FIELD_CREATED_AT = 'created_at';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
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
