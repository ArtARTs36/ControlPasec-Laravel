<?php

namespace App\Services;

use App\Bundles\Contragent\Models\Contragent;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Class SupplyService
 * @package App\Services
 */
final class SupplyService
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
     * @param Collection|SupplyProduct[]|array $products
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

    public static function fullLoadSupply($id): Supply
    {
        $supply = Supply::find($id);
        $supply->supplier->load([
            'requisites' => function ($requisite) {
                return $requisite->with('bank');
            },
            'customer',
        ]);

        $supply->products()->with(['parent' => function ($parent) {
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
