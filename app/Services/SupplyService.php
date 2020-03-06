<?php

namespace App\Services;

use App\Models\Contragent;
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
            $totalPrice += $product->getTotalPrice();
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

    public static function fullLoadSupply($id): Supply
    {
        $supply = Supply::find($id);
        $supplier = $supply->supplier->load(['requisites' => function ($requisite) {
            return $requisite->with('bank');
        }]);
        $customer = $supply->customer;
        $products = $supply->products()->with(['parent' => function ($parent) {
            return $parent->with(['sizeOfUnit', 'gosStandard']);
        }])->get();

        return $supply;
    }

    /**
     * @param Contragent $customer
     * @param Contragent $supplier
     * @param \DateTime|null $dateTime
     * @return Supply
     * @throws \Exception
     */
    public static function create(Contragent $customer, Contragent $supplier, \DateTime $dateTime = null): Supply
    {
        $supply = new Supply();
        $supply->customer_id = $customer->id;
        $supply->supplier_id = $supplier->id;
        $supply->planned_date = $dateTime ?? new \DateTime();
        $supply->save();

        return $supply;
    }
}
