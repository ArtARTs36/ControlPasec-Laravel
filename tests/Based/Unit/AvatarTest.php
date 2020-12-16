<?php

namespace Tests\Based\Unit;

use App\Based\Support\Avatar;
use App\User;
use Tests\BaseTestCase;

class AvatarTest extends BaseTestCase
{
    /**
     * @covers Avatar::byUser
     */
    public function testGetByUser(): void
    {
        $user = factory(User::class)->create();

        $avatar = Avatar::byUser($user);
        $condition = preg_match('/males/i', $avatar) > 0;

        self::assertIsString($avatar);
        self::assertTrue($condition);
    }
}
