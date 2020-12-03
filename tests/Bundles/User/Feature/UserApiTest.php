<?php

namespace Tests\Bundles\User\Feature;

use App\Models\User\Permission;
use App\User;
use Tests\BaseTestCase;

final class UserApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/users/';

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\RoleSeeder::class);
        $this->seed(\PermissionSeeder::class);
    }

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
}
