<?php

namespace Tests\Feature;

use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ExternalNewsTest extends BaseTestCase
{
    public function testChart(): void
    {
        $count = rand(5, 15);
        $response = $this->getJson("/api/external-news/chart/{$count}");

        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
    }
}
