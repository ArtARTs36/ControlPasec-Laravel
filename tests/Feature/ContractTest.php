<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

class ContractTest extends BaseTestCase
{
    public function testContractCreate()
    {
        $response = $this->postJson('contracts', [
            'title' => 'Договор на поставку меда',
            'customer_id' => 1,
            'supplier_id' => 2
        ]);

        $response = json_decode($response->getContent(), true);

        self::assertTrue($response['customer_id'] == 1 && $response['supplier_id'] == 2);
    }
}
