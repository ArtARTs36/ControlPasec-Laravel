<?php

namespace App\Bundles\Plant\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Plant\Models\Plant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Bundles\Plant\Contracts\PlantRepository as MainContract;
use Illuminate\Support\Collection;

final class PlantRepository extends Repository implements MainContract
{
    public function find(int $id): ?Plant
    {
        return $this->newQuery()->find($id);
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        return $this
            ->modify()
            ->with(Plant::RELATION_CATEGORY)
            ->paginate(10, ['*'], 'PlantList', $page);
    }

    public function all(): Collection
    {
        return $this->newQuery()->get();
    }
}
