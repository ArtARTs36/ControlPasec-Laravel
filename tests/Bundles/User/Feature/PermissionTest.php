<?php

namespace Tests\Bundles\User\Feature;

use App\Models\User\Permission;
use Tests\BaseTestCase;

final class PermissionTest extends BaseTestCase
{
    private const BASE_URL = '/api/permissions';

    /**
     * @covers \App\Bundles\User\Http\Controllers\PermissionController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        //

        $request()->assertForbidden();

        //

        $this->actingAsUserWithPermission(Permission::PERMISSIONS_LIST_VIEW);

        $request()->assertOk();
    }
}
