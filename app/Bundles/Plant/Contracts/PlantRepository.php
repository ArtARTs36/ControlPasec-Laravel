<?php

namespace App\Bundles\Plant\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlantRepository
{
    public function paginate(int $page): LengthAwarePaginator;
}
