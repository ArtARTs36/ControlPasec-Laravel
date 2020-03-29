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
        return Role::where('is_allowed_for_sign_up', true)->get();
    }
}
