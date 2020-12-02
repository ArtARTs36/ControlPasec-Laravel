<?php

namespace Tests\Feature;

use App\Models\Contract\Contract;
use App\Bundles\Contragent\Models\Contragent;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ContractTest extends BaseTestCase
{
    private const API_URL = '/api/contracts/';

    /**
     * Тест на создание договора
     */
    public function testContractCreate(): void
    {
        $customerId = $this->getRandomModel(Contragent::class)->id;
        $supplierId = env('ONE_SUPPLIER_ID');

        $this->actingAsUserWithPermission(Permission::CONTRACTS_CREATE);

        $response = $this->postJson(static::API_URL, [
            'title' => 'Договор на поставку меда',
            'customer_id' => $customerId,
            'supplier_id' => $supplierId,
            'planned_date' => '2020-02-09',
            'executed_date' => '2020-02-09',
        ]);

        $response = $response->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('data', $response);
        self::assertIsArray($response['data']);
        self::assertEquals($customerId, $response['data']['customer_id']);
        self::assertEquals($supplierId, $response['data']['supplier_id']);
    }

    public function testFindByCustomer(): void
    {
        $customer = Contragent::query()
            ->whereHas(Contragent::RELATION_CONTRACTS)
            ->inRandomOrder()
            ->first();

        $response = $this->getJson("/api/contracts/find-by-customer/{$customer->id}");

        $response->assertOk();
    }

    /**
     * Тест на удаление договора
     */
    public function testContractDelete(): void
    {
        /** @var Contract $contract */
        $contract = $this->getRandomModel(Contract::class);

        $this->actingAsUserWithPermission(Permission::CONTRACTS_DELETE);

        $response = $this->deleteJson(static::API_URL. $contract->id)
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
    }
}
