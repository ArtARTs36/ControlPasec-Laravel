<?php

namespace App\Bundles\Plant\DTO;

class BringForecast
{
    public $start;

    public $end;

    public $bees;

    public $square;

    public function __construct(
        \DateTimeInterface $start,
        \DateTimeInterface $end,
        int $bees,
        float $square
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->bees = $bees;
        $this->square = $square;
    }
}
