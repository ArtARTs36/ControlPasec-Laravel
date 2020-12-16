<?php

namespace Tests\Bundles\Vocab\Feature;

use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabPackageType;
use Tests\BaseTestCase;

class VocabPackageTypeApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/vocab/package-types';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabPackageTypeController::store
     */
    public function testStore(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(static::BASE_URL, $data);
        };

        //

        $request()->assertForbidden();

        //

        $this->actingAsUserWithPermission(Permission::VOCAB_PACKAGE_TYPES_CREATE);

        $request([
            VocabPackageType::FIELD_NAME => 'Название',
        ])->assertOk();
    }
}
