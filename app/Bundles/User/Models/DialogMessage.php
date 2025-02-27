<?php

namespace App\Bundles\User\Models;

use App\Based\ModelSupport\WithFieldIsRead;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DialogMessage
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $dialog_id
 * @property bool $is_read
 * @property string $text
 * @property string $created_at
 * @property User $fromUser
 * @property Carbon $updated_at
 */
class DialogMessage extends Model
{
    use WithFieldIsRead;

    public const FIELD_TO_USER_ID = 'to_user_id';
    public const FIELD_FROM_USER_ID = 'from_user_id';
    public const FIELD_IS_READ = 'is_read';

    public const RELATION_FROM_USER = 'fromUser';
    public const RELATION_TO_USER = 'toUser';

    public function dialog(): BelongsTo
    {
        return $this->belongsTo(Dialog::class);
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCurrentUserAuthor(): bool
    {
        return $this->from_user_id === auth()->user()->id;
    }
}
