<?php

namespace Tests\Bundles\Plant\Feature;

use App\Bundles\Plant\Models\Category;
use App\Bundles\Plant\Models\Plant;
use Tests\TestCase;

final class PlantTest extends TestCase
{
    private const BASE_URL = 'api/plants';

    /**
     * @covers \App\Bundles\Plant\Http\Controllers\PlantController::index
     */
    public function testIndex(): void
    {
        $response = $this->getJson(self::BASE_URL);

        $response->assertOk();
    }

    /**
     * @covers \App\Bundles\Plant\Http\Controllers\PlantController::store
     */
    public function testStore(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(self::BASE_URL, $data);
        };

        $request()->assertStatus(422);

        //

        $request([
            Plant::FIELD_NAME => 'Name',
            Plant::FIELD_CATEGORY_ID => factory(Category::class)->create()->id,
        ])->assertCreated();
    }
}
