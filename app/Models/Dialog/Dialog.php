<?php

namespace App\Models\Dialog;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Dialog
 * @property int id
 * @property int one_user_id
 * @property int two_user_id
 * @property bool is_one_user_hidden
 * @property bool is_two_user_hidden
 * @property DialogMessage[]|Collection messages
 * @mixin Builder
 */
class Dialog extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('lastMessages', function (Builder $builder) {
            $builder->with(['messages' => function (HasMany $builder) {
                $builder->latest('created_at');
            }]);
        });
    }

    public function oneUser()
    {
        return $this->belongsTo(User::class);
    }

    public function twoUser()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(DialogMessage::class);
    }

    public function getLastMessage(): DialogMessage
    {
        $this->loadMissing('messages');

        return $this->messages->last();
    }

    public function hideForCurrentUser(): self
    {
        $currentUserId = auth()->user()->id;

        if ($this->one_user_id === $currentUserId) {
            $this->is_one_user_hidden = true;
        } elseif ($this->two_user_id === $currentUserId) {
            $this->is_two_user_hidden = true;
        }

        $this->save();

        return $this;
    }
}
