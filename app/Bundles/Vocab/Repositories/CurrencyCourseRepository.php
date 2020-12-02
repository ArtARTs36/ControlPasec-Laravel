<?php

namespace App\Bundles\Vocab\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Vocab\Models\CurrencyCourse;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CurrencyCourseRepository
 * @package App\Repositories
 */
class CurrencyCourseRepository extends Repository
{
    /**
     * @return Collection|CurrencyCourse[]
     */
    public function last(): Collection
    {
        return $this->newQuery()
            ->with(CurrencyCourse::RELATION_CURRENCY)
            ->orderBy(CurrencyCourse::FIELD_ACTUAL_DATE, 'desc')
            ->take(100)
            ->get();
    }
}
