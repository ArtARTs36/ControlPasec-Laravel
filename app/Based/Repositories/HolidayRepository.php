<?php

namespace App\Based\Repositories;

use App\Based\Contracts\Repository;
use ArtARTs36\LaravelHoliday\Models\Holiday;
use Illuminate\Support\Collection;

class HolidayRepository extends Repository
{
    protected function getModelClass(): string
    {
        return Holiday::class;
    }

    /**
     * @return Collection<Holiday>|Holiday[]
     */
    public function getWithTypeByPeriod(\DateTimeInterface $start, \DateTimeInterface $end): Collection
    {
        return $this
            ->newQuery()
            ->with(Holiday::RELATION_WORK_TYPE)
            ->whereDate(Holiday::FIELD_DATE, '>=', $start)
            ->whereDate(Holiday::FIELD_DATE, '<=', $end)
            ->get();
    }
}
