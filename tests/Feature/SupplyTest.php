<?php

namespace Tests\Feature;

use App\Models\Product\Product;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use Tests\BaseTestCase;

class SupplyTest extends BaseTestCase
{
    public function testCreate()
    {
        $response = $this->postJson('supplies', [
            'planned_date' => '2020-02-08 18:18:32',
            'execute_date' => '2020-02-08 18:18:32',
            'supplier_id' => 1,
            'customer_id' => 1
        ]);

        $response = $this->decodeResponse($response);

        self::assertTrue($response['data']['id'] > 0);
    }

    public function testSupplyProductCreate()
    {
        /** @var Supply $randomSupply */
        $randomSupply = Supply::where('id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        /** @var Product $randomProduct */
        $randomProduct = Product::where('id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $product = new SupplyProduct();
        $product->product_id = $randomProduct->id;
        $product->price = rand(5, 1000);
        $product->mount = rand(5, 1000);
        $product->supply_id = $randomSupply->id;
        $product->save();

        self::assertTrue($product->id > 0);
    }
}
