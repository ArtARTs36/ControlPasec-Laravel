<?php

namespace Tests\Bundles\User\Feature;

use Tests\BaseTestCase;

final class ProfileTest extends BaseTestCase
{
    private const SEARCH_URL = '/api/profiles/search/admin';

    /**
     * @covers \App\Bundles\User\Http\Controllers\ProfileController::search
     */
    public function testSearch(): void
    {
        $this->actingAsRandomUser();

        $response = $this->getJson(static::SEARCH_URL);
        $data = $this->decodeResponse($response);

        $response->assertOk();
        self::assertArrayHasKey('data', $data);
        self::assertArrayHasKey(0, $data['data']);
        self::assertArrayHasKey('name', $data['data'][0]);
        self::assertTrue($data['data'][0]['name'] === 'admin');
    }
}
