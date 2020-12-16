<?php

namespace Tests\Bundles\Vocab\Feature;

use App\Bundles\Vocab\Models\SizeOfUnit;
use Tests\BaseTestCase;

final class SizeOfUnitApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/vocab/size-of-units/';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        //

        $request()->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::store
     */
    public function testStore(): void
    {
        $request = function (array $data) {
            return $this->postJson(static::BASE_URL, $data);
        };

        //

        $request([
            SizeOfUnit::FIELD_NAME => 'Test',
            SizeOfUnit::FIELD_NAME_EN => 'Test',
            SizeOfUnit::FIELD_SHORT_NAME_EN => 'Ts',
            SizeOfUnit::FIELD_SHORT_NAME => 'Ts',
            SizeOfUnit::FIELD_OKEI => 123,
        ])->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::destroy
     */
    public function testDestroy(): void
    {
        $request = function (int $id) {
            return $this->deleteJson(static::BASE_URL . $id);
        };

        // 1. Сущности не существует

        $request(999)->assertNotFound();

        // 2. OK

        $unit = factory(SizeOfUnit::class)->create();

        $request($unit->id)->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\SizeOfUnitController::update
     */
    public function testUpdate(): void
    {
        $request = function (int $id, array $data = []) {
            return $this->putJson(static::BASE_URL . $id, $data);
        };

        // 1. Сущность не существует

        $request(999)->assertNotFound();

        // 2. OK

        $unit = factory(SizeOfUnit::class)->create();

        $request($unit->id, [
            SizeOfUnit::FIELD_NAME => 'Test',
            SizeOfUnit::FIELD_NAME_EN => 'Test',
            SizeOfUnit::FIELD_SHORT_NAME_EN => 'Ts',
            SizeOfUnit::FIELD_SHORT_NAME => 'Ts',
            SizeOfUnit::FIELD_OKEI => 123,
        ])->assertOk();
    }
}
