<?php

namespace App\Models\Dialog;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DialogMessage
 * @property int id
 * @property int from_user_id
 * @property int to_user_id
 * @property int dialog_id
 * @property bool is_read
 * @property string text
 * @property string created_at
 * @property User fromUser
 * @mixin Builder
 */
class DialogMessage extends Model
{
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
        if ($this->isNotRead()) {
            $this->is_read = true;
        }

        $this->save();

        return $this;
    }

    public function isCurrentUserAuthor(): bool
    {
        return $this->from_user_id === auth()->user()->id;
    }
}
