<?php

namespace App\Services;

use App\User;

class UserService
{
    public static function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
