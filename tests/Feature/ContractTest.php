<?php

namespace Tests\Feature;

use App\Models\Contract\Contract;
use App\Models\Contragent;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ContractTest extends BaseTestCase
{
    /**
     * Тест на создание договора
     */
    public function testContractCreate(): void
    {
        $response = $this->postJson('/api/contracts', [
            'title' => 'Договор на поставку меда',
            'customer_id' => 10,
            'supplier_id' => 1,
            'planned_date' => '2020-02-09',
            'executed_date' => '2020-02-09',
        ]);

        $response = $this->decodeResponse($response);

        self::assertTrue(
            $response['data']['customer_id'] == 10 && $response['data']['supplier_id'] == 1
        );
    }

    public function testFindByCustomer(): void
    {
        $customer = Contragent::with(['contracts'])->inRandomOrder()->get()->first();

        $response = $this->getJson('/api/contracts/find-by-customer/'. $customer->id);

        $response->assertStatus(200);
    }

    /**
     * Тест на удаление договора
     */
    public function testContractDelete(): void
    {
        /** @var Contract $contract */
        $contract = Contract::where('id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $response = $this->deleteJson('/api/contracts/'. $contract->id);

        $response = $this->decodeResponse($response);

        self::assertTrue($response === null);
    }
}
