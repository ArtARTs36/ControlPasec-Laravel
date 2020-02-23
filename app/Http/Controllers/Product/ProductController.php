<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Product\Product;
use App\Models\Supply\SupplyProduct;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return Product::with(['currency', 'sizeOfUnit', 'gosStandard'])->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return new ActionResponse(true, $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return void
     */
    public function update(Request $request, Product $product)
    {
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return void
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Самые продаваемые продукты
     *
     * @return array
     */
    public function topChart(): array
    {
        $supplyProducts = SupplyProduct::with('parent')->get();
        $products = [];

        /** @var SupplyProduct[] $supplyProducts */
        foreach ($supplyProducts as $realization) {
            if (!isset($products[$realization->product_id])) {
                $products[$realization->product_id] = $realization->parent;
                $products[$realization->product_id]->quantities = 0;
                $products[$realization->product_id]->prices = 0;
            }

            $products[$realization->product_id]->quantities += $realization->quantity;
            $products[$realization->product_id]->prices += $realization->quantity *$realization->price;
        }

        usort($products, function($one, $two) {
            return ($one['quantities'] < $two['quantities']);
        });

        return array_chunk($products, 5)[0];
    }
}
