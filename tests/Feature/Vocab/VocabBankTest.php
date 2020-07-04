<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabBank;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabBankTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-banks';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabBankController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabBank::class)->make()->toArray();

        $response = $this->postJson(self::API_INDEX, $data)
            ->assertOk()
            ->decodeResponseJson();

        foreach ($data as $field => $value) {
            self::assertEquals($value, $response['data'][$field]);
        }
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabBankController::show
     */
    public function testShow(): void
    {
        $bank = factory(VocabBank::class)->create();

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $bank->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabBankController::update
     */
    public function testUpdate(): void
    {
        $bank = factory(VocabBank::class)->create();
        $newData = factory(VocabBank::class)->make()->toArray();

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $bank->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabBankController::destroy
     */
    public function testDestroy(): void
    {
        $bank = factory(VocabBank::class)->create();

        //$this->actingAsUserWithPermission(Permission::VOCAB_BANKS_DELETE);

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $bank->id)
            ->assertOk();

        self::assertNull(VocabBank::query()->find($bank->id));
    }
}
