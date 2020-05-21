<?php

namespace Tests\Feature;

use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ProductTest extends BaseTestCase
{
    public function testGetAll(): void
    {
        $this->actingAsUserWithPermission(Permission::PRODUCTS_LIST_VIEW);

        $response = $this->getJson('/api/products');
        $decode = $response->decodeResponseJson();

        $response->assertOk();

        self::assertNotEmpty($decode);
        self::assertIsArray($decode);
        self::assertArrayHasKey('data', $decode);
        self::assertGreaterThan(0, $decode['data']);
    }
}
