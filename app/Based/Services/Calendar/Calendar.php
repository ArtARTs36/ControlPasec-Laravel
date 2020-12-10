<?php

namespace App\Based\Services\Calendar;

use App\Based\Contracts\CalendarModule;

class Calendar
{
    protected $modules;

    /**
     * @param CalendarModule[] $modules
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;
    }

    public function getByDates(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        $response = [];

        foreach ($this->modules as $module) {
            foreach ($module->fetch($start, $end) as $event) {
                $response[] = [
                    'title' => $event->getTitle(),
                    'date' => $event->getYmdDate(),
                    'type' => $event->getType(),
                ];
            }
        }

        return $response;
    }
}
