<?php

namespace Tests\Feature;

use App\Models\Contract\Contract;
use Tests\BaseTestCase;

class ContractTest extends BaseTestCase
{
    /**
     * Тест на создание договора
     */
    public function testContractCreate()
    {
        $response = $this->postJson('contracts', [
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

    /**
     * Тест на удаление договора
     */
    public function testContractDelete()
    {
        /** @var Contract $contract */
        $contract = Contract::where('id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $response = $this->deleteJson('contracts/'. $contract->id);

        $response = $this->decodeResponse($response);

        self::assertTrue($response === null);
    }
}
