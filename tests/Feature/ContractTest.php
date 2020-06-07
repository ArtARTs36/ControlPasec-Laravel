<?php

namespace Tests\Feature;

use App\Models\Contract\Contract;
use App\Models\Contragent;
use Illuminate\Http\Response;
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
        $customerId = $this->getRandomModel(Contragent::class)->id;
        $supplierId = env('ONE_SUPPLIER_ID');

        $response = $this->postJson('/api/contracts', [
            'title' => 'Договор на поставку меда',
            'customer_id' => $customerId,
            'supplier_id' => $supplierId,
            'planned_date' => '2020-02-09',
            'executed_date' => '2020-02-09',
        ]);

        $response->assertOk();

        $response = $this->decodeResponse($response);

        self::assertTrue(
            $response['data']['customer_id'] == $customerId && $response['data']['supplier_id'] == $supplierId
        );
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

        $response = $this->deleteJson('/api/contracts/'. $contract->id)
            ->assertStatus(Response::HTTP_OK);

        $response = $this->decodeResponse($response);

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
    }
}
