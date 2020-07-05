<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\SizeOfUnit;
use Illuminate\Support\Arr;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class SizeOfUnitTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab/size-of-units';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::store
     */
    public function testStore(): void
    {
        $data = factory(SizeOfUnit::class)->make()->toArray();

        $this->postJson(static::API_INDEX, $data)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::show
     */
    public function testShow(): void
    {
        $unit = factory(SizeOfUnit::class)->create();

        $response = $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id)
            ->assertOk()
            ->decodeResponseJson();

        self::assertEquals(
            Arr::sort($unit->toArray()),
            Arr::sort($response)
        );
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::update
     */
    public function testUpdate(): void
    {
        $unit = factory(SizeOfUnit::class)->create();
        $newData = factory(SizeOfUnit::class)->make()->toArray();

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::destroy
     */
    public function testDestroy(): void
    {
        $unit = factory(SizeOfUnit::class)->create();

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id)
            ->assertOk();
    }
}
