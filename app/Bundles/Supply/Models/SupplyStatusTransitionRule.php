<?php

namespace App\Bundles\Supply\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property int $from_status_id
 * @property SupplyStatus $fromStatus
 * @property int $to_status_id
 * @property SupplyStatus $toStatus
 * @property \DateTimeInterface $created_at
 * @property int $creator_id
 * @property User $creator
 */
class SupplyStatusTransitionRule extends Model
{
    public const FIELD_ID = 'id';
    public const FIELD_TITLE = 'title';
    public const FIELD_FROM_STATUS_ID = 'from_status_id';
    public const FIELD_TO_STATUS_ID = 'to_status_id';
    public const FIELD_CREATOR_ID = 'creator_id';

    public const RELATION_FROM_STATUS = 'fromStatus';
    public const RELATION_TO_STATUS = 'toStatus';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_FROM_STATUS_ID,
        self::FIELD_TO_STATUS_ID,
        self::CREATED_AT,
        self::FIELD_CREATOR_ID,
    ];

    public $timestamps = false;

    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(SupplyStatus::class);
    }

    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(SupplyStatus::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
