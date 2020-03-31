<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public static function liveFind(string $query)
    {
        return User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('patronymic', 'LIKE', "%{$query}%")
            ->orWhere('family', 'LIKE', "%{$query}%")
            ->orWhere('position', 'LIKE', "%{$query}%")
            ->get();
    }
}
