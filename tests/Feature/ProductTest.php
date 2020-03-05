<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

class ProductTest extends BaseTestCase
{
    public function testGetAll()
    {
        $response = $this->decodeResponse($this->getJson('/api/products'));

        self::assertTrue(
            is_array($response['data']) && count($response['data']) > 0
        );
    }
}
