<?php

namespace App\Bundles\Plant\Contracts;

use App\Bundles\Plant\Models\Plant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PlantRepository
{
    public function find(int $id): ?Plant;

    public function paginate(int $page): LengthAwarePaginator;

    public function all(): Collection;
}
