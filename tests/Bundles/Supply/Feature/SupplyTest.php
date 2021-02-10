<?php

namespace Tests\Bundles\Supply\Feature;

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Product\Models\Product;
use App\Bundles\Supply\Services\SupplyCreateOptions\CreateScoreForPayment;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyProduct;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use Illuminate\Http\Response;
use Tests\BaseTestCase;

final class SupplyTest extends BaseTestCase
{
    private const API_URL = '/api/supplies';

    /**
     * @covers \App\Bundles\Supply\Http\Controllers\SupplyController::index
     */
    public function testIndex(): void
    {
        $this->actingAsUserWithPermission(Permission::SUPPLIES_VIEW);

        $response = $this->getJson(self::API_URL);

        $response->assertOk();

        self::assertIsArray($response['data']);
    }

    /**
     * @covers \App\Bundles\Supply\Http\Controllers\SupplyController::store
     */
    public function testCreate(): void
    {
        $supplierId = factory(Contragent::class)->create()->id;
        $customerId = factory(Contragent::class)->create()->id;

        $this->actingAsUserWithPermission(Permission::SUPPLIES_CREATE);

        $response = $this->postJson(self::API_URL, [
            'planned_date' => '2020-02-08 18:18:32',
            'execute_date' => '2020-02-08 18:18:32',
            'supplier_id' => $supplierId,
            'customer_id' => $customerId,
        ]);

        $response->assertOk();

        $response = $response->decodeResponseJson();

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('id', $response['data']);
        self::assertGreaterThan(1, $response['data']['id']);
        self::assertEquals($response['data']['supplier_id'], $supplierId);
        self::assertEquals($response['data']['customer_id'], $customerId);
    }

    public function testStoreMany(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(static::API_URL . '/store-many', $data);
        };

        $data = [
            'options' => [
                CreateScoreForPayment::OPTION_NAME,
            ]
        ];

        for ($i = 0; $i < 20; $i++) {
            $data['items'][] = [
                Supply::FIELD_PLANNED_DATE => $this->getFaker()->dateTime()->format('Y-m-d H:i:s'),
                Supply::FIELD_SUPPLIER_ID => factory(Contragent::class)->create()->id,
                Supply::FIELD_CUSTOMER_ID => factory(Contragent::class)->create()->id,
                Supply::RELATION_PRODUCTS => array_map(function () {
                    return [
                            SupplyProduct::FIELD_PRICE => rand(1000, 100000),
                            SupplyProduct::FIELD_QUANTITY => rand(1000, 100000),
                            SupplyProduct::FIELD_PARENT_ID => factory(Product::class)->create()->id,
                            SupplyProduct::FIELD_QUANTITY_UNIT_ID => factory(VocabQuantityUnit::class)->create()->id,
                        ];
                }, range(0, 10)),
            ];
        }

        $response = $request($data)
            ->assertOk()
            ->decodeResponseJson();

        //

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);

        foreach ($data['items'] as $supplyData) {
            /** @var Supply $supply */
            $supply = Supply::query()
                ->where(Supply::FIELD_PLANNED_DATE, $supplyData[Supply::FIELD_PLANNED_DATE])
                ->where(Supply::FIELD_SUPPLIER_ID, $supplyData[Supply::FIELD_SUPPLIER_ID])
                ->where(Supply::FIELD_CUSTOMER_ID, $supplyData[Supply::FIELD_CUSTOMER_ID])
                ->first();

            self::assertNotNull($supply);

            self::assertEquals(1, $supply->scoreForPayments()->count());

            $productsData = collect($supplyData[Supply::RELATION_PRODUCTS])->sort();

            foreach ($supply->products->sort() as $key => $product) {
                self::assertEquals($productsData[$key][SupplyProduct::FIELD_PRICE], $product->price);
                self::assertEquals($productsData[$key][SupplyProduct::FIELD_QUANTITY], $product->quantity);
                self::assertEquals($productsData[$key][SupplyProduct::FIELD_PARENT_ID], $product->product_id);
                self::assertEquals($productsData[$key][SupplyProduct::FIELD_QUANTITY_UNIT_ID], $product->quantity_unit_id);
            }
        }
    }

    public function testStoreManyBad(): void
    {
        $data = [
            'items' => [

            ],
        ];

        $this->postJson(static::API_URL . '/store-many', $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
