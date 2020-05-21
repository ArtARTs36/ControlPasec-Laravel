<?php

namespace Tests\Feature;

use App\Models\Contragent;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class SupplyTest extends BaseTestCase
{
    const API_URL = '/api/supplies';

    public function testGetAll(): void
    {
        $this->actingAsUserWithPermission(Permission::SUPPLIES_VIEW);

        $response = $this->getJson(self::API_URL);
        $decode = $response->decodeResponseJson();

        $response->assertOk();

        self::assertIsArray($response['data']);
    }

    public function testCreate(): void
    {
        $supplierId = $this->getRandomModel(Contragent::class)->id;
        $customerId = $this->getRandomModel(Contragent::class)->id;

        $response = $this->postJson(self::API_URL, [
            'planned_date' => '2020-02-08 18:18:32',
            'execute_date' => '2020-02-08 18:18:32',
            'supplier_id' => $supplierId,
            'customer_id' => $customerId,
        ]);

        $response->assertOk();

        $response = $this->decodeResponse($response);

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
        self::assertArrayHasKey('data', $response);
        self::assertArrayHasKey('id', $response['data']);
        self::assertTrue($response['data']['id'] > 0);
        self::assertTrue($response['data']['supplier_id'] === $supplierId);
        self::assertTrue($response['data']['customer_id'] === $customerId);
    }
}
