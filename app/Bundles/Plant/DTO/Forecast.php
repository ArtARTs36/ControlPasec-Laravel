<?php

namespace App\Bundles\Plant\DTO;

use App\Bundles\Plant\Models\Plant;
use ArtARTs36\LaravelWeather\Models\Day;

class Forecast
{
    public $weight;

    public $days;

    public $start;

    public $end;

    public $request;

    public $plant;

    /**
     * @param Day[] $days
     */
    public function __construct(
        float $weight,
        array $days,
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        BringForecast $request,
        Plant $plant
    ) {
        $this->weight = $weight;
        $this->days = $days;
        $this->start = $start;
        $this->end = $end;
        $this->request = $request;
        $this->plant = $plant;
    }
}
