<?php

namespace App\Repositories;

use App\Support\SqlRawString;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public static function liveFind(string $find)
    {
        $findWithoutFirstSymbol = mb_substr($find, 1);

        return User::query()->where(User::FIELD_IS_ACTIVE, true)
            ->where(function (Builder $query) use ($find, $findWithoutFirstSymbol) {
                $query
                    ->where(...SqlRawString::byLowerAndLike(User::FIELD_NAME, $find))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_NAME, $findWithoutFirstSymbol))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_PATRONYMIC, $find))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_PATRONYMIC, $findWithoutFirstSymbol))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_FAMILY, $find))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_FAMILY, $findWithoutFirstSymbol))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_POSITION, $find))
                    ->orWhere(...SqlRawString::byLowerAndLike(User::FIELD_POSITION, $findWithoutFirstSymbol));
            })
            ->get();
    }

    public static function getByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
