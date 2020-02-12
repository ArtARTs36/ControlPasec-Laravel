<?php

namespace Tests\Feature;

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

        self::assertTrue($response['id'] > 0);
    }

    public function testSupplyProductCreate()
    {
        $product = new SupplyProduct();
        $product->product_id = 1;
        $product->price = 1.4;
        $product->mount = 30;
        $product->supply_id = 6;
        $product->save();

        self::assertTrue($product->id > 0);
    }
}
