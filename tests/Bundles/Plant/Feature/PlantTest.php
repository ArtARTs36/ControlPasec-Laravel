<?php

namespace Tests\Bundles\Plant\Feature;

use Tests\TestCase;

final class PlantTest extends TestCase
{
    /**
     * @covers \App\Bundles\Plant\Http\Controllers\PlantController::index
     */
    public function testIndex(): void
    {
        $response = $this->getJson('/api/plants');

        $response->assertOk();
    }
}
