<?php

namespace App\Bundles\Plant\Services;

use App\Bundles\Plant\Models\NectarProductivity;
use ArtARTs36\LaravelWeather\Models\Day;

class ProductivityForecaster
{
    public const AVAILABLE_TEMPERATURE = 32;
    public const MIN_AVAILABLE_TEMPERATURE = 23;

    /** @var Day[] */
    protected $days;

    /**
     * @param Day[] $days
     */
    public function bring(
        NectarProductivity $productivity,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        array $days,
        int $bees
    ): float {
        $this->days = $this->prepareDays($days);

        $sum = 0;

        $period = $this->createDatePeriod($startDate, $endDate);

        foreach ($period as $date) {
            $availableNectar = $this->bringAvailableNectarOnDate($productivity, $date);

            if ($availableNectar === 0) {
                continue;
            }

            $taken = ($bees * 10) * 0.00045;

            if ($availableNectar < $taken) {
                $taken = $availableNectar;
            }

            $sum += $taken;
        }

        return $sum;
    }

    protected function bringAvailableNectarOnDate(NectarProductivity $productivity, \DateTimeInterface $date): float
    {
        $day = $this->days[$date->format('Y-m-d')];

        // Температура меньше допустимой - пчела ничего не соберет
        if ($day->temperature < static::MIN_AVAILABLE_TEMPERATURE) {
            return 0;
        }

        // Если цветок на данный день не цветет => 0
        if (! $productivity->plant->isBloomedOnDate($day->date)) {
            return 0;
        }

        if ($productivity->isMinEqualsMax()) {
            $diff = $productivity->nectar_min / $productivity->plant->getBloomedDays();
        } else {
            $diff = ($productivity->nectar_max - $productivity->nectar_min) / $productivity->plant->getBloomedDays();
        }

        return ($productivity->nectar_min + ($diff * $this->bringCoefficient($day))) * 0.5;
    }

    protected function bringCoefficient(Day $day): float
    {
        return $day->temperature / static::AVAILABLE_TEMPERATURE;
    }

    protected function createDatePeriod(\DateTimeInterface $start, \DateTimeInterface $end): \DatePeriod
    {
        return new \DatePeriod($start, \DateInterval::createFromDateString('1 day'), $end);
    }

    /**
     * @param Day[] $days
     * @return Day[]
     */
    protected function prepareDays(array $days): array
    {
        $dict = [];

        foreach ($days as $day) {
            $dict[$day->date->format('Y-m-d')] = $day;
        }

        return $dict;
    }
}
