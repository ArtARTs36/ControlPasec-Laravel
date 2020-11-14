<?php

namespace App\Services\Supply;

use App\Models\Product\Product;
use App\Models\Supply\SupplyProduct;

class SupplyProductService
{
    /**
     * @param Product $parent
     * @return SupplyProduct
     */
    public static function makeSupplyProductOfParent(Product $parent): SupplyProduct
    {
        $product = new SupplyProduct();
        $product->product_id = $parent->id;
        $product->price = $parent->price;
        $product->quantity_unit_id = $parent->quantity_unit_id;

        return $product;
    }
}
