<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyProduct;
use Illuminate\Support\Arr;

final class SupplyService
{
    /**
     * @return float|int
     */
    public function bringTotalPrice(Supply $supply)
    {
        if ($supply->products->isEmpty()) {
            return 0;
        }

        return self::bringTotalPriceByProducts($supply->products);
    }

    /**
     * @param \iterable|SupplyProduct[] $products
     * @return float|int
     */
    public static function bringTotalPriceByProducts($products)
    {
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->getTotalPrice();
        }

        return $totalPrice;
    }

    public function checkProductsInSupply(array $data, int $supplyId = null)
    {
        $supplyId = $supplyId ?? $data['id'];

        if (! isset($data['products'])) {
            return null;
        }

        $supplyProducts = SupplyProduct::query()
            ->findMany(Arr::pluck($data['products'], 'id'))
            ->pluck(null, 'id');

        foreach ($data['products'] as $productData) {
            if (! isset($productData['id'])) {
                $product = new SupplyProduct();
                $product->fill($productData);
                $product->supply_id = $supplyId;
                $product->save();

                continue;
            }

            $supplyProducts[$productData['id']]->update($productData);
        }
    }

    /**
     * @return Supply
     * @throws \Exception
     */
    public function create(Contragent $customer, Contragent $supplier, ?\DateTime $dateTime = null): Supply
    {
        $supply = new Supply();
        $supply->customer_id = $customer->id;
        $supply->supplier_id = $supplier->id;
        $supply->planned_date = $dateTime ?? new \DateTime();
        $supply->save();

        return $supply;
    }

    /**
     * @todo уйти от .env
     * сделать в таблице поле position
     * @return int
     */
    public function getDefaultId(): int
    {
        return (int) env('ONE_SUPPLIER_ID');
    }
}
