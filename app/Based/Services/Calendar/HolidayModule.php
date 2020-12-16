<?php

namespace App\Based\Services\Calendar;

use App\Based\Contracts\CalendarModule;
use App\Based\Repositories\HolidayRepository;
use Carbon\Carbon;

class HolidayModule implements CalendarModule
{
    protected $repository;

    public function __construct(HolidayRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetch(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $events = [];

        foreach ($this->repository->getWithTypeByPeriod($start, $end) as $holiday) {
            $events[] = new Event(
                Carbon::parse($holiday->date),
                $holiday->workType->title,
                'holiday'
            );
        }

        return $events;
    }
}
