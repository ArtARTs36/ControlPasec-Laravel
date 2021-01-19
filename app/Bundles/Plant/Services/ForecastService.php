<?php

namespace App\Bundles\Plant\Services;

use App\Bundles\Plant\DTO\BringForecast;
use App\Bundles\Plant\DTO\Forecast;
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

    public function generate(NectarProductivity $productivity, BringForecast $request): Forecast
    {
        $days = $this->weatherRepository->getByDates($request->start, $request->end);
        $weight = $this->forecaster->bring($productivity, $days->all(), $request);

        return new Forecast($weight, $days->all(), $request->start, $request->end);
    }
}
