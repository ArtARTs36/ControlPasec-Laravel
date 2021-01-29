<?php

namespace App\Bundles\Plant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Plant $plant
 * @property int $plant_id
 * @property int $nectar_min - Нектар, кг/га
 * @property int $nectar_max - Нектар, кг/га
 */
class NectarProductivity extends Model
{
    public const FIELD_PLANT_ID = 'plant_id';
    public const FIELD_NECTAR_MIN = 'nectar_min';
    public const FIELD_NECTAR_MAX = 'nectar_max';

    protected $table = 'nectar_productivity';

    protected $fillable = [
        self::FIELD_PLANT_ID,
        self::FIELD_NECTAR_MIN,
        self::FIELD_NECTAR_MAX,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function isMinEqualsMax(): bool
    {
        return $this->nectar_min === $this->nectar_max;
    }
}
