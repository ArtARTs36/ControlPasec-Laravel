<?php

namespace App\Bundles\Plant\Models;

use App\Based\Support\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property Category $category
 * @property int $bloom_start_month
 * @property int $bloom_start_day
 * @property int $bloom_end_month
 * @property int $bloom_end_day
 */
class Plant extends Model
{
    public const FIELD_NAME = 'name';
    public const FIELD_CATEGORY_ID = 'category_id';
    public const RELATION_CATEGORY = 'category';

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

    public function isBloomedOnDate(\DateTimeInterface $date): bool
    {
        $start = $this->makeBloomedStartDateOnYear($year = $date->format('Y'));
        $end = $this->makeBloomedEndDateOnYear($year);

        return $date >= $start && $end >= $date;
    }

    public function getBloomedDays(): int
    {
        return Date::getCountFromPeriod($this->getBloomedDatePeriod());
    }

    public function getBloomedDatePeriod(): \DatePeriod
    {
        $start = $this->makeBloomedStartDateOnYear($year = (new \DateTime())->format('Y'));
        $end = $this->makeBloomedEndDateOnYear($year);

        return new \DatePeriod($start, \DateInterval::createFromDateString('1 day'), $end);
    }

    protected function makeBloomedStartDateOnYear(int $year): \DateTimeInterface
    {
        return (new \DateTime())->setDate($year, $this->bloom_start_month, $this->bloom_start_day);
    }

    protected function makeBloomedEndDateOnYear(int $year): \DateTimeInterface
    {
        return (new \DateTime())->setDate($year, $this->bloom_end_month, $this->bloom_end_day);
    }
}
