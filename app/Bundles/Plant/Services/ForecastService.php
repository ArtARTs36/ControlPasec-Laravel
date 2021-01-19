<?php

namespace App\Bundles\Plant\Services;

use App\Bundles\Plant\Models\NectarProductivity;
use ArtARTs36\LaravelWeather\Repositories\DayRepository;

class ForecastService
{
    protected $weatherRepository;

    protected $forecaster;

    public function __construct(DayRepository $weatherRepository, ProductivityForecaster $forecaster)
    {
        $this->weatherRepository = $weatherRepository;
        $this->forecaster = $forecaster;
    }

    public function generate(
        NectarProductivity $productivity,
        \DateTimeInterface $startDate,
        \DateTimeInterface $endDate,
        int $bees,
        int $square
    ): array {
        $days = $this->weatherRepository->getByDates($startDate, $endDate);

        return [
            'weight' => $this->forecaster->bring($productivity, $startDate, $endDate, $days->all(), $bees, $square),
            'days' => $days,
        ];
    }
}
