<?php

namespace App\Repositories;

use App\Models\Vocab\CurrencyCourse;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CurrencyCourseRepository
 * @package App\Repositories
 */
class CurrencyCourseRepository
{
    /**
     * @return Collection|CurrencyCourse[]
     */
    public static function last(): Collection
    {
        return CurrencyCourse::query()
            ->with(CurrencyCourse::RELATION_CURRENCY)
            ->orderBy(CurrencyCourse::FIELD_ACTUAL_DATE, 'desc')
            ->take(100)
            ->get();
    }
}
