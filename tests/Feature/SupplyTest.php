<?php

namespace Tests\Feature;

use App\Models\Product\Product;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use App\Models\Vocab\VocabQuantityUnit;
use Tests\BaseTestCase;

class SupplyTest extends BaseTestCase
{
    public function testGetAll()
    {
        $response = $this->decodeResponse(
            $this->getJson('supplies')
        );

        self::assertIsArray($response['data']);
    }

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
        $product = new SupplyProduct();
        $product->product_id = $this->getRandomModel(Product::class)->id;
        $product->price = rand(5, 1000);
        $product->quantity = rand(5, 1000);
        $product->supply_id = $this->getRandomModel(Supply::class)->id;
        $product->quantity_unit_id = $this->getRandomModel(VocabQuantityUnit::class)->id;
        $product->save();

        self::assertTrue($product->id > 0);
    }
}
