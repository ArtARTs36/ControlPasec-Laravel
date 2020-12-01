<?php

namespace App\Bundles\TechSupport\Models;

use App\Models\Traits\WithFieldIsRead;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property User|null $user
 * @property int $user_id
 * @property string $author_title
 * @property string $author_contact
 * @property string $message
 * @property string $ip
 * @property bool $is_read
 * @property string $created_at
 * @property string $updated_at
 */
class TechSupportReport extends Model
{
    use WithFieldIsRead;

    public const FIELD_MESSAGE = 'message';
    public const FIELD_IP = 'ip';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_AUTHOR_TITLE = 'author_title';
    public const FIELD_AUTHOR_CONTACT = 'author_contact';

    public const RELATION_USER = 'user';

    protected $fillable = [
        self::FIELD_MESSAGE,
        self::FIELD_IP,
        self::FIELD_USER_ID,
        self::FIELD_AUTHOR_TITLE,
        self::FIELD_AUTHOR_CONTACT,
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeUser', function (Builder $builder) {
            $builder->with(static::RELATION_USER);
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    public function isWroteByGuest(): bool
    {
        return $this->user === null;
    }

    public function getAuthorFullName(): string
    {
        return $this->isWroteByGuest() ? $this->author_title : $this->user->getFullName();
    }
}
