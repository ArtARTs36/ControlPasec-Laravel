<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public static function liveFind(string $find)
    {
        return User::where('is_active', true)
            ->where(function ($query) use ($find) {
                $query->where('name', 'LIKE', "%{$find}%")
                    ->orWhere('patronymic', 'LIKE', "%{$find}%")
                    ->orWhere('family', 'LIKE', "%{$find}%")
                    ->orWhere('position', 'LIKE', "%{$find}%");
            })
            ->get();
    }

    public static function getByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
