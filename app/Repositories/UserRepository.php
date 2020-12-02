<?php

namespace App\Repositories;

use App\Based\Support\Avatar;
use App\Support\SqlRawString;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public static function paginate(int $page): LengthAwarePaginator
    {
        return User::query()
            ->latest('id')
            ->paginate(10, ['*'], 'UsersList', $page);
    }

    /**
     * @param string $find
     * @return Collection
     */
    public static function liveFind(string $find): Collection
    {
        $findWithoutFirstSymbol = mb_substr($find, 1);

        return User::query()
            ->where(User::FIELD_IS_ACTIVE, true)
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

    /**
     * @param string $email
     * @return User|null
     */
    public static function getByEmail(string $email): ?User
    {
        return User::query()->where(User::FIELD_EMAIL, $email)->first();
    }

    /**
     * @param array $data
     * @return User
     */
    public static function create(array $data): User
    {
        return User::query()->create(array_merge(
            $data,
            [
                'is_active' => false,
                'password' => Hash::make($data['password']),
                'avatar_url' => Avatar::random(),
            ]
        ));
    }
}
