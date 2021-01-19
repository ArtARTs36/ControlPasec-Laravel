<?php

namespace App\Bundles\Plant\DTO;

use ArtARTs36\LaravelWeather\Models\Day;

class Forecast
{
    public $weight;

    public $days;

    public $start;

    public $end;

    /**
     * @param Day[] $days
     */
    public function __construct(float $weight, array $days, \DateTimeInterface $start, \DateTimeInterface $end)
    {
        $this->weight = $weight;
        $this->days = $days;
        $this->start = $start;
        $this->end = $end;
    }
}
