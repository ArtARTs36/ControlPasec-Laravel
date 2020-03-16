<?php

namespace Tests\Feature;

use App\Http\Resource\UserResource;
use App\User;
use Tests\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @group BaseTest
 */
class AuthTest extends BaseTestCase
{
    /**
     * @var array
     */
    protected $tokens = [];

    protected $admin;

    protected $simpleUser;

    /**
     * SetUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('name', 'admin')->first();

        \Auth::guard('api')->attempt(['email' => $user->login, 'password' => $user->password]);
        $this->admin = $user;

        $this->tokens['admin'] = JWTAuth::fromUser($this->admin);

        $this->simpleUser = User::where('email', '<>', $this->admin->email)->first();
        $this->tokens['simpleUser'] = JWTAuth::fromUser($this->simpleUser);
    }

    public function testMeByAdmin()
    {
        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->tokens['admin']])
            ->get('/api/me');

        $response->assertStatus(200);
    }
}
