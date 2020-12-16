<?php

namespace App\Based\Contracts;

use App\Based\Services\Calendar\Event;

interface CalendarModule
{
    /**
     * @return Event[]
     */
    public function fetch(\DateTimeInterface $start, \DateTimeInterface $end): array;
}
