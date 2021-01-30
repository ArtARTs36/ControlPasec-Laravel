<?php

namespace App\Bundles\Plant\Models;

use App\Based\Support\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $start_month
 * @property int $start_day
 * @property int $end_month
 * @property int $end_day
 * @property int $plant_id
 * @property Plant $plant
 */
class PlantBloom extends Model
{
    public const FIELD_START_MONTH = 'start_month';
    public const FIELD_START_DAY = 'start_day';
    public const FIELD_END_MONTH = 'end_month';
    public const FIELD_END_DAY = 'end_day';
    public const FIELD_PLANT_ID = 'plant_id';

    protected $fillable = [
        self::FIELD_START_MONTH,
        self::FIELD_START_DAY,
        self::FIELD_END_MONTH,
        self::FIELD_END_DAY,
        self::FIELD_PLANT_ID,
    ];

    protected $endDatesOnYears = [];

    protected $startDatesOnYears = [];

    protected $periodsOnYears = [];

    /**
     * @codeCoverageIgnore
     */
    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function isBloomedOnYear(\DateTimeInterface $date): bool
    {
        $start = $this->makeBloomedStartDateOnYear($year = (int) $date->format('Y'));
        $end = $this->makeBloomedEndDateOnYear($year);

        return $date >= $start && $end >= $date;
    }

    public function getBloomedDatePeriodOnYear(int $year): \DatePeriod
    {
        if (! isset($this->periodsOnYears[$year])) {
            $start = $this->makeBloomedStartDateOnYear($year);
            $end = $this->makeBloomedEndDateOnYear($year);

            $this->periodsOnYears[$year] =  new \DatePeriod(
                $start,
                \DateInterval::createFromDateString('1 day'),
                $end
            );
        }

        return $this->periodsOnYears[$year];
    }

    public function makeBloomedStartDateOnYear(int $year): \DateTimeInterface
    {
        if (! isset($this->startDatesOnYears[$year])) {
            $this->startDatesOnYears[$year] = (new \DateTime())->setDate($year, $this->start_month, $this->start_day);
        }

        return $this->startDatesOnYears[$year];
    }

    public function makeBloomedEndDateOnYear(int $year): \DateTimeInterface
    {
        if (! isset($this->endDatesOnYears[$year])) {
            $this->endDatesOnYears[$year] = (new \DateTime())->setDate($year, $this->end_month, $this->end_day);
        }

        return $this->endDatesOnYears[$year];
    }
}
