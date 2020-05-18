<?php

namespace Tests\Feature;

use App\Models\User\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

class RegisterController extends BaseTestCase
{
    use RefreshDatabase;
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
        return [
            'name' => $this->faker()->word,
            'patronymic' => $this->faker()->word,
            'family' => $this->faker()->word,
            'role_id' => Role::where(Role::FIELD_IS_ALLOWED_FOR_SIGN_UP, $roleAllowed)->first()->id,
            'password' => $this->faker()->password,
            'email' => $this->faker()->email,
        ];
    }
}
