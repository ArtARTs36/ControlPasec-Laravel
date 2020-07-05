<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabQuantityUnit;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabQuantityUnitTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-quantity-units';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabQuantityUnit::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_QUANTITY_UNITS_CREATE);

        $response = $this->postJson(self::API_INDEX, $data)
            ->assertOk()
            ->decodeResponseJson();

        foreach ($data as $field => $value) {
            self::assertEquals($value, $response['data'][$field]);
        }
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController::show
     */
    public function testShow(): void
    {
        $unit = factory(VocabQuantityUnit::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_QUANTITY_UNITS_VIEW);

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController::update
     */
    public function testUpdate(): void
    {
        $unit = factory(VocabQuantityUnit::class)->create();
        $newData = factory(VocabQuantityUnit::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_QUANTITY_UNITS_EDIT);

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabQuantityUnitController::destroy
     */
    public function testDestroy(): void
    {
        $unit = factory(VocabQuantityUnit::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_QUANTITY_UNITS_DELETE);

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $unit->id)
            ->assertOk();

        self::assertNull(VocabQuantityUnit::query()->find($unit->id));
    }
}
