<?php

namespace App\Services;

use App\Models\Product\Product;
use App\Models\Supply\SupplyProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class ProductService
{
    private const CACHE_TOP_CHART_KEY = 'product_top-chart';

    public function getStat(int $count): array
    {
        if (!($products = Cache::get(static::CACHE_TOP_CHART_KEY))) {
            $products = array_slice($this->bringStat(), 0, $count, true);

            Cache::put(static::CACHE_TOP_CHART_KEY, $products, Carbon::now()->addHour(1));
        }

        return $products;
    }

    public function bringStat(): array
    {
        $supplyProducts = SupplyProduct::query()
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

        $products = [];

        /** @var Collection|SupplyProduct[] $supplyProducts */
        foreach ($supplyProducts as $realization) {
            if (!isset($products[$realization->product_id])) {
                $products[$realization->product_id] = $realization->parent;
                $products[$realization->product_id]->quantities = 0;
                $products[$realization->product_id]->prices = 0;
            }

            $products[$realization->product_id]->quantities += $realization->quantity;
            $products[$realization->product_id]->prices += $realization->quantity * $realization->price;
        }

        usort($products, function ($one, $two) {
            return ($one['quantities'] < $two['quantities']);
        });

        return $products;
    }

    public function cleanStatCache(): void
    {
        Cache::forget(static::CACHE_TOP_CHART_KEY);
    }
}
