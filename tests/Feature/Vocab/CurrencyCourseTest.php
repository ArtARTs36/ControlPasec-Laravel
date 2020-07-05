<?php

namespace Tests\Feature\Vocab;

use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class CurrencyCourseTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab/currency-courses';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\CurrencyCourseController::chart
     */
    public function testChart(): void
    {
        $response = $this->getJson(static::API_INDEX)
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('datasets', $response);
        self::assertNotEmpty($response['datasets']);
        self::assertArrayHasKey('labels', $response);
        self::assertNotEmpty($response['labels']);
    }
}
