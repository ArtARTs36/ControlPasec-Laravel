<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabPackageType;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabPackageTypeTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-package-types';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabPackageType::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_PACKAGE_TYPES_CREATE);

        $response = $this->postJson(self::API_INDEX, $data)
            ->assertOk()
            ->decodeResponseJson();

        foreach ($data as $field => $value) {
            self::assertEquals($value, $response['data'][$field]);
        }
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController::show
     */
    public function testShow(): void
    {
        $type = factory(VocabPackageType::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_PACKAGE_TYPES_VIEW);

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $type->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController::update
     */
    public function testUpdate(): void
    {
        $type = factory(VocabPackageType::class)->create();
        $newData = factory(VocabPackageType::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_PACKAGE_TYPES_EDIT);

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $type->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController::destroy
     */
    public function testDestroy(): void
    {
        $type = factory(VocabPackageType::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_PACKAGE_TYPES_DELETE);

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $type->id)
            ->assertOk();

        self::assertNull(VocabQuantityUnit::query()->find($type->id));
    }
}
