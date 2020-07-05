<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabWord;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabWordTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-words';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabWordController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabWord::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_WORDS_CREATE);

        $response = $this->postJson(self::API_INDEX, $data)
            ->assertCreated()
            ->decodeResponseJson();

        foreach ($data as $field => $value) {
            self::assertEquals($value, $response[$field]);
        }
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabWordController::show
     */
    public function testShow(): void
    {
        $word = factory(VocabWord::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_WORD_VIEW);

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $word->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabWordController::update
     */
    public function testUpdate(): void
    {
        $word = factory(VocabWord::class)->create();
        $newData = factory(VocabWord::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_WORD_UPDATE);

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $word->id, $newData)
            ->assertOk();
    }
}
