<?php

namespace Tests\Bundles\Supply\Feature;

use App\Bundles\Supply\Models\Contract;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\User\Models\Permission;
use Tests\BaseTestCase;

final class ContractTest extends BaseTestCase
{
    private const API_URL = '/api/contracts/';

    /**
     * Тест на создание договора
     */
    public function testContractCreate(): void
    {
        $customerId = factory(Contragent::class)->create()->id;
        // @todo
        $supplierId = env('ONE_SUPPLIER_ID');

        $this->actingAsUserWithPermission(Permission::CONTRACTS_CREATE);

        $response = $this->postJson(static::API_URL, [
            'title' => 'Договор на поставку меда',
            'customer_id' => $customerId,
            'supplier_id' => $supplierId,
            'planned_date' => '2020-02-09',
            'executed_date' => '2020-02-09',
        ]);

        $response->dump();

        $response = $response->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('data', $response);
        self::assertIsArray($response['data']);
        self::assertEquals($customerId, $response['data']['customer_id']);
        self::assertEquals($supplierId, $response['data']['supplier_id']);
    }

    /**
     * @covers ContractController::findByCustomer
     */
    public function testFindByCustomer(): void
    {
        $customer = factory(Contragent::class)->create();

        $response = $this->getJson("/api/contracts/find-by-customer/{$customer->id}");

        $response->assertOk();
    }

    /**
     * Тест на удаление договора
     */
    public function testContractDelete(): void
    {
        /** @var Contract $contract */
        $contract = factory(Contract::class)->create();

        $this->actingAsUserWithPermission(Permission::CONTRACTS_DELETE);

        $response = $this->deleteJson(static::API_URL. $contract->id)
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
    }
}
