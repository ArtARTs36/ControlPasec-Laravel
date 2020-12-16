<?php

namespace App\Bundles\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * Class UserNotificationType
 * @property int $id
 * @property string $name
 * @property string $title
 * @property Permission $permission
 * @mixin Builder
 */
final class UserNotificationType extends Model
{
    public const USER_REGISTERED = 'user_registered';
    public const LANDING_FEED_BACK_CREATED = 'landing_feed_back_created';
    public const TECH_SUPPORT_REPORT_CREATED = 'tech_support_report_created';
    public const DOCUMENT_OF_QUEUE_GENERATED = 'document_of_queue_generated';

    public const FIELD_NAME = 'name';

    public const RELATION_PERMISSION = 'permission';

    /**
     * @codeCoverageIgnore
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }
}
