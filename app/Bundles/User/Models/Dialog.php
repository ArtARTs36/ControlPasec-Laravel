<?php

namespace App\Bundles\User\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Dialog
 * @property int $id
 * @property int $one_user_id
 * @property-read User $oneUser
 * @property-read User $twoUser
 * @property int $two_user_id
 * @property bool $is_one_user_hidden
 * @property bool $is_two_user_hidden
 * @property DialogMessage[]|Collection $messages
 * @mixin Builder
 */
class Dialog extends Model
{
    public const FIELD_ONE_USER_ID = 'one_user_id';
    public const FIELD_TWO_USER_ID = 'two_user_id';
    public const FIELD_UPDATED_AT = 'updated_at';

    public const RELATION_MESSAGES = 'messages';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('lastMessages', function (Builder $builder) {
            $builder->with([static::RELATION_MESSAGES => function (HasMany $builder) {
                $builder->latest(DialogMessage::CREATED_AT);
            }]);
        });
    }

    /**
     * @return BelongsTo
     */
    public function oneUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function twoUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getInterUser(User $comparedUser): User
    {
        if ($this->one_user_id === $comparedUser->id) {
            return $this->twoUser;
        }

        if ($this->two_user_id === $comparedUser->id) {
            return $this->oneUser;
        }

        throw new \LogicException('Пользователь не учавствует в диалоге!');
    }

    /**
     * Учавствует ли $user в диалоге
     */
    public function isTookPart(User $user): bool
    {
        return $this->one_user_id === $user->id || $this->two_user_id === $user->id;
    }

    /**
     * НЕ учавствует ли $user в диалоге
     */
    public function isNotTookPart(User $user): bool
    {
        return ! $this->isTookPart($user);
    }

    /**
     * @codeCoverageIgnore
     */
    public function messages(): HasMany
    {
        return $this->hasMany(DialogMessage::class);
    }

    /**
     * @return DialogMessage
     */
    public function getLastMessage(): DialogMessage
    {
        $this->loadMissing('messages');

        return $this->messages->last();
    }

    /**
     * Скрыть диалог для пользователя
     *
     * @param User $user
     * @return Dialog
     */
    public function hide(User $user): self
    {
        return $this->hideByUserId($user->id);
    }

    /**
     * Скрыть диалог для пользователя с $id
     *
     * @param int $id
     * @return $this
     */
    public function hideByUserId(int $id): self
    {
        if ($this->one_user_id === $id) {
            $this->is_one_user_hidden = true;
        } elseif ($this->two_user_id === $id) {
            $this->is_two_user_hidden = true;
        }

        $this->save();

        return $this;
    }
}
