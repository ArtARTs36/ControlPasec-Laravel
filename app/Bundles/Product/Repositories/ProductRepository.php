<?php

namespace App\Bundles\Product\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends Repository
{
    public function paginate(int $page = 1): LengthAwarePaginator
    {
        return $this->newQuery()
            ->with([
                Product::RELATION_CURRENCY,
                Product::RELATION_SIZE_OF_UNIT,
                Product::RELATION_GOS_STANDARD,
            ])
            ->paginate(10, ['*'], 'ProductsList', $page);
    }
}
