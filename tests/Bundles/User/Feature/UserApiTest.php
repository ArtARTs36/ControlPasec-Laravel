<?php

namespace Tests\Bundles\User\Feature;

use App\User;
use Tests\BaseTestCase;

final class UserApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/users/';

    /**
     * @covers \App\Bundles\User\Http\Controllers\UserController::show
     */
    public function testShow(): void
    {
        $request = function (User $user) {
            return $this->getJson(static::BASE_URL . $user->id);
        };

        $user = factory(User::class)->create();

        //

        $request($user)->assertOk();
    }
}
