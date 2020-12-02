<?php

namespace App\Repositories;

use App\Based\Contracts\Repository;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Collection;

final class RoleRepository extends Repository
{
    /**
     * @return Collection<Role>
     */
    public function getAllowedForSignUp(): Collection
    {
        return Role::where(Role::FIELD_IS_ALLOWED_FOR_SIGN_UP, true)->get();
    }
}
