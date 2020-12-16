<?php

namespace Tests\Bundles\Vocab\Feature;

use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabWord;
use Tests\BaseTestCase;

final class VocabWordApiTest extends BaseTestCase
{
    private const BASE_URL = 'api/vocab-words';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabWordController::store
     */
    public function testStore(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(static::BASE_URL, $data);
        };

        $data = factory(VocabWord::class)->make()->toArray();

        $request($data)->assertForbidden();

        $this->actingAsUserWithPermission(Permission::VOCAB_WORDS_CREATE);

        $request($data)->assertCreated();
    }
}
