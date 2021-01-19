<?php

namespace App\Bundles\Plant\Services;

use App\Bundles\Plant\DTO\BringForecast;
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

    public function generate(NectarProductivity $productivity, BringForecast $request): array
    {
        $days = $this->weatherRepository->getByDates($request->start, $request->end);

        return [
            'weight' => $this->forecaster->bring($productivity, $days->all(), $request),
            'days' => $days,
        ];
    }
}
