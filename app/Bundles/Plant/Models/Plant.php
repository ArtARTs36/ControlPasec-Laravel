<?php

namespace App\Bundles\Plant\Models;

use App\Based\ModelSupport\WithFillOfRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property Category $category
 * @property PlantBloom[]|Collection $blooms
 */
class Plant extends Model
{
    use WithFillOfRequest;

    public const FIELD_NAME = 'name';
    public const FIELD_CATEGORY_ID = 'category_id';
    public const RELATION_CATEGORY = 'category';
    public const RELATION_BLOOMS = 'blooms';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_CATEGORY_ID,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function blooms(): HasMany
    {
        return $this->hasMany(PlantBloom::class);
    }

    public function isBloomedOnDate(\DateTimeInterface $date): bool
    {
        return $this->getBloomedPeriod($date) !== null;
    }

    public function getBloomedPeriod(\DateTimeInterface $date): ?\DatePeriod
    {
        if ($this->blooms->isEmpty()) {
            return null;
        }

        foreach ($this->blooms as $bloom) {
            if ($bloom->isBloomedOnYear($date)) {
                return $bloom->getBloomedDatePeriodOnYear($date->format('Y'));
            }
        }

        return null;
    }
}
