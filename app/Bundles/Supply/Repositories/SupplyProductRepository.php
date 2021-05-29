<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Product\Models\Product;
use App\Bundles\Supply\Models\SupplyProduct;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class SupplyProductRepository extends Repository
{
    /**
     * @return Collection|SupplyProduct[]
     */
    public function getAllWithParentAndCurrency(): Collection
    {
        return SupplyProduct::query()
            ->with([SupplyProduct::RELATION_PARENT => function (BelongsTo $product) {
                $product
                    ->distinct()
                    ->with([
                        Product::RELATION_CURRENCY => function (BelongsTo $query) {
                            $query->distinct();
                        },
                    ]);
            }])->get([
                SupplyProduct::FIELD_PARENT_ID,
                SupplyProduct::FIELD_QUANTITY,
                SupplyProduct::FIELD_PRICE,
            ]);
    }
}
