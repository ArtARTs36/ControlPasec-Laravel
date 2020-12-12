<?php

namespace Tests\Bundles\User\Feature;

use App\Bundles\User\Models\Permission;
use App\User;
use Tests\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $this->actingAsUserWithPermission(Permission::USERS_VIEW);

        $request($user)->assertOk();
    }

    /**
     * @covers \App\Bundles\User\Http\Controllers\UserController::store
     */
    public function testStore(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(static::BASE_URL, $data);
        };

        //

        $request()->assertForbidden();

        //

        $this->actingAsUserWithPermission(Permission::USERS_CREATE);

        $request([
            'name' => 'Артем',
            'patronymic' => 'Викторович',
            'family' => 'Украинский',
            'position' => 'Dev',
            'password' => '123456',
            'email' => 'test@mail.ru',
        ])->assertOk();
    }

    /**
     * @covers \App\Bundles\User\Http\Controllers\UserController::me
     */
    public function testMe(): void
    {
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get('/api/me');

        $response->assertStatus(200);
    }
}
