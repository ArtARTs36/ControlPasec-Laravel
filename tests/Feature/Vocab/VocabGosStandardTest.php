<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabGosStandard;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabGosStandardTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-gos-standards';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabGosStandardController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabGosStandard::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_GOS_STANDARD_CREATE);

        $response = $this->postJson(self::API_INDEX, $data)
            ->assertOk()
            ->decodeResponseJson();

        foreach ($data as $field => $value) {
            self::assertEquals($value, $response['data'][$field]);
        }
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabGosStandardController::show
     */
    public function testShow(): void
    {
        $standard = factory(VocabGosStandard::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_GOS_STANDARD_VIEW);

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $standard->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabGosStandardController::update
     */
    public function testUpdate(): void
    {
        $standard = factory(VocabGosStandard::class)->create();
        $newData = factory(VocabGosStandard::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_GOS_STANDARD_EDIT);

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $standard->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabGosStandardController::destroy
     */
    public function testDestroy(): void
    {
        $standard = factory(VocabGosStandard::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_GOS_STANDARD_DELETE);

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $standard->id)
            ->assertOk();

        self::assertNull(VocabGosStandard::query()->find($standard->id));
    }
}
