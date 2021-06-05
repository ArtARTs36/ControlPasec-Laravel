<?php

namespace App\Bundles\Supply\Models;

use App\Bundles\Supply\Support\WithSupply;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $supply_id
 * @property Supply $supply
 * @property int $from_status_id
 * @property SupplyStatus $fromStatus
 * @property int $to_status_id
 * @property SupplyStatus $toStatus
 * @property int $user_id
 * @property User $user
 * @property \DateTimeInterface $executed_at
 */
class SupplyStatusTransition extends Model
{
    use WithSupply;

    public const FIELD_ID = 'id';
    public const FIELD_SUPPLY_ID = 'supply_id';
    public const FIELD_FROM_STATUS_ID = 'from_status_id';
    public const FIELD_TO_STATUS_ID = 'to_status_id';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_EXECUTED_AT = 'executed_at';

    public const RELATION_FROM_STATUS = 'fromStatus';
    public const RELATION_TO_STATUS = 'toStatus';
    public const RELATION_USER = 'user';

    public $timestamps = false;

    protected $fillable = [
        self::FIELD_SUPPLY_ID,
        self::FIELD_FROM_STATUS_ID,
        self::FIELD_TO_STATUS_ID,
        self::FIELD_USER_ID,
        self::FIELD_EXECUTED_AT,
    ];

    protected $dates = [
        self::FIELD_EXECUTED_AT,
    ];

    public function fromStatus(): BelongsTo
    {
        return $this->belongsTo(SupplyStatus::class);
    }

    public function toStatus(): BelongsTo
    {
        return $this->belongsTo(SupplyStatus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
