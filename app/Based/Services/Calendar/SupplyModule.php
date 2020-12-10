<?php

namespace App\Based\Services\Calendar;

use App\Based\Contracts\CalendarModule;
use App\Bundles\Supply\Repositories\SupplyRepository;
use App\Models\Supply\Supply;
use Carbon\Carbon;

class SupplyModule implements CalendarModule
{
    protected $repository;

    public function __construct(SupplyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function fetch(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $events = [];

        foreach ($this->repository->getWithCustomerByDates($start, $end) as $supply) {
            $events[] = new Event(Carbon::parse($supply->planned_date), $this->createTitle($supply), 'supply');
        }

        return $events;
    }

    protected function createTitle(Supply $supply): string
    {
        $message = 'Поставка #'. $supply->id;

        if ($supply->customer) {
            $message .= '. Заказчик: '. $supply->customer->title;
        }

        return $message;
    }
}
