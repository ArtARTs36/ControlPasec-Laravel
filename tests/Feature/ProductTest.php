<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ProductTest extends BaseTestCase
{
    public function testGetAll(): void
    {
        $response = $this->decodeResponse($this->getJson('/api/products'));

        self::assertTrue(is_array($response['data']) && count($response['data']) > 0);
    }
}
