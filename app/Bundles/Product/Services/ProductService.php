<?php

namespace App\Bundles\Product\Services;

use App\Bundles\Product\Models\Product;
use App\Bundles\Product\Repositories\ProductRepository;
use App\Bundles\Supply\Models\SupplyProduct;
use App\Bundles\Supply\Repositories\SupplyProductRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const CACHE_TOP_CHART_KEY = 'product_top-chart';

    protected $products;

    protected $realizations;

    public function __construct(ProductRepository $products, SupplyProductRepository $realizations)
    {
        $this->products = $products;
        $this->realizations = $realizations;
    }

    /**
     * @return LengthAwarePaginator|Product[]
     */
    public function show(int $page): LengthAwarePaginator
    {
        return $this->products->paginate($page);
    }

    public function getStat(int $count): array
    {
        if (! ($products = Cache::get(static::CACHE_TOP_CHART_KEY))) {
            $products = array_slice(static::bringStat(), 0, $count, true);

            Cache::put(static::CACHE_TOP_CHART_KEY, $products, Carbon::now()->addHour());
        }

        return $products;
    }

    public function bringStat(): array
    {
        $supplyProducts = $this->realizations->getAllWithParentAndCurrency();

        $products = [];

        /** @var Collection|SupplyProduct[] $supplyProducts */
        foreach ($supplyProducts as $realization) {
            if (! isset($products[$realization->product_id])) {
                $products[$realization->product_id] = $realization->parent;
                $products[$realization->product_id]->quantities = 0;
                $products[$realization->product_id]->prices = 0;
            }

            $products[$realization->product_id]->quantities += $realization->quantity;
            $products[$realization->product_id]->prices += $realization->quantity * $realization->price;
        }

        usort($products, function ($one, $two) {
            return $one['quantities'] < $two['quantities'];
        });

        return $products;
    }

    public static function cleanStatCache(): void
    {
        Cache::forget(static::CACHE_TOP_CHART_KEY);
    }
}
