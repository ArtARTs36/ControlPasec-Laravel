<?php

namespace Tests\Bundles\Contragent\Feature;

use App\Bundles\User\Models\Permission;
use Tests\BaseTestCase;

final class ContragentTest extends BaseTestCase
{
    private const BASE_URL = 'api/contragents/';

    /**
     * @covers \App\Bundles\Contragent\Http\Controllers\ContragentController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        //

        $request()->assertForbidden();

        //

        $this->actingAsUserWithPermission(Permission::CONTRAGENTS_LIST_VIEW);

        $request()->assertOk();
    }
}
