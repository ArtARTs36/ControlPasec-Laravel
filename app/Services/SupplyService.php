<?php

namespace App\Services;

use App\Http\Requests\SupplyRequest;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;

class SupplyService
{
    /**
     * @param Supply $supply
     * @return float|int
     */
    public static function bringTotalPrice(Supply $supply)
    {
        if (!isset($supply->products)) {
            return 0;
        }

        return self::bringTotalPriceByProducts($supply->products);
    }

    /**
     * @param $products
     * @return float|int
     */
    public static function bringTotalPriceByProducts($products)
    {
        $totalPrice = 0;

        /** @var SupplyProduct $product */
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->mount;
        }

        return $totalPrice;
    }

    public static function checkProductsInSupply($data, $supplyId = null)
    {
        $supplyId = $supplyId ?? $data['id'];

        if (!isset($data['products'])) {
            return null;
        }

        foreach ($data['products'] as $productData) {
            if (!isset($productData['id'])) {
                $product = new SupplyProduct();
                $product->supply_id = $supplyId;
                $product->fill($productData);
                $product->save();

                continue;
            }

            $product = SupplyProduct::find($productData['id']);
            $product->update($productData);
        }
    }
}
