<?php

namespace App\Services;

use App\Models\Supply\SupplyProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const CACHE_TOP_CHART_KEY = 'product_top-chart';

    public static function getStat(int $count): array
    {
        if (!($products = Cache::get(static::CACHE_TOP_CHART_KEY))) {
            $products = array_slice(static::bringStat(), 0, $count, true);

            Cache::put(static::CACHE_TOP_CHART_KEY, $products, Carbon::now()->addHour(1));
        }

        return $products;
    }

    public static function bringStat(): array
    {
        $supplyProducts = SupplyProduct::query()
            ->with(['parent' => function (BelongsTo $product) {
                $product
                    ->distinct()
                    ->with([
                        'currency' => function (BelongsTo $query) {
                            $query->distinct();
                        },
                    ]);
            }])->get([
                'product_id',
                'quantity',
                'price',
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

    public static function cleanStatCache(): void
    {
        Cache::forget(static::CACHE_TOP_CHART_KEY);
    }
}
