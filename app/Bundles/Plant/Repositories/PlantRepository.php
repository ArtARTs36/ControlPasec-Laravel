<?php

namespace App\Bundles\Plant\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Plant\Models\Plant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Bundles\Plant\Contracts\PlantRepository as MainContract;

final class PlantRepository extends Repository implements MainContract
{
    public function paginate(int $page): LengthAwarePaginator
    {
        return $this
            ->newQuery()
            ->with(Plant::RELATION_CATEGORY)
            ->paginate(10, ['*'], 'PlantList', $page);
    }
}
