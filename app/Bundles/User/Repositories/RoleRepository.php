<?php

namespace App\Repositories;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    /**
     * @return Collection|Role[]
     */
    public static function getAllowedForSignUp(): Collection
    {
        return Role::query()
            ->where(Role::FIELD_IS_ALLOWED_FOR_SIGN_UP, true)
            ->get();
    }
}
