<?php

namespace App\Repositories;

use App\Models\Product\Product;

class ProductRepository
{
    public static function paginate(int $page = 1)
    {
        return Product::query()
            ->with([
                Product::RELATION_CURRENCY,
                Product::RELATION_SIZE_OF_UNIT,
                Product::RELATION_GOS_STANDARD,
            ])
            ->paginate(10, ['*'], 'ProductsList', $page);
    }
}
