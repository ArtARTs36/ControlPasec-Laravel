<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ProfileTest extends BaseTestCase
{
    public function testSearch(): void
    {
        $apiUrl = '/api/profiles/search/admin';

        $response = $this->getJson($apiUrl);
        $data = $this->decodeResponse($response);

        $response->assertOk();
        self::assertArrayHasKey('data', $data);
        self::assertArrayHasKey(0, $data['data']);
        self::assertArrayHasKey('name', $data['data'][0]);
        self::assertTrue($data['data'][0]['name'] === 'admin');
    }
}
