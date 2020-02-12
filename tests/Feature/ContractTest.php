<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

class ContractTest extends BaseTestCase
{
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

        self::assertTrue($response['customer_id'] == 10 && $response['supplier_id'] == 1);
    }

    public function testContractDelete()
    {
        $response = $this->deleteJson('contracts/5');

        $response = $this->decodeResponse($response);

        self::assertTrue($response === null);
    }
}
