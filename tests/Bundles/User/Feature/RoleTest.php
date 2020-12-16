<?php

namespace Tests\Bundles\User\Feature;

use App\Bundles\User\Models\Permission;
use Tests\BaseTestCase;

final class RoleTest extends BaseTestCase
{
    private const BASE_URL = '/api/roles';

    /**
     * @covers RoleController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        //

        $request()->assertForbidden();

        //

        $this->actingAsUserWithPermission(Permission::ROLE_LIST_VIEW);

        $request()->assertOk();
    }
}
