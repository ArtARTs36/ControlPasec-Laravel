<?php

namespace Tests\Bundles\User\Feature;

use App\Bundles\User\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

final class RegisterTest extends BaseTestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();
    }

    public function testSuccess(): void
    {
        $response = $this
            ->post('/api/signup', $this->makeRequestData(true));

        $decode = $response->decodeResponseJson();

        $response->assertOk();
        static::assertArrayHasKey('success', $decode);
        static::assertTrue($decode['success']);
    }

    public function testWithRoleNotAllowed(): void
    {
        $response = $this
            ->post('/api/signup', $this->makeRequestData(false));

        $decode = $response->decodeResponseJson();

        static::assertArrayHasKey('success', $decode);
        static::assertFalse($decode['success']);
    }

    private function makeRequestData(bool $roleAllowed): array
    {
        /** @var Role $role */
        $role = factory(Role::class)->make();
        $role->is_allowed_for_sign_up = $roleAllowed;
        $role->save();

        return [
            'name' => $this->faker()->word,
            'patronymic' => $this->faker()->word,
            'family' => $this->faker()->word,
            'role_id' => $role->id,
            'password' => $this->faker()->password,
            'email' => $this->faker()->email,
        ];
    }
}
