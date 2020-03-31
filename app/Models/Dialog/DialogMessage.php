<?php

namespace App\Models\Dialog;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class);
    }

    public function isRead()
    {
        return $this->is_read === true;
    }

    public function isNotRead()
    {
        return $this->is_read === false;
    }

    public function read(): self
    {
        $this->is_read = true;
        $this->save();

        return $this;
    }

    public function isCurrentUserAuthor(): bool
    {
        return $this->from_user_id === auth()->user()->id;
    }
}
