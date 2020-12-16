<?php

namespace App\Bundles\User\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\User\Models\Role;
use Illuminate\Database\Eloquent\Collection;

final class RoleRepository extends Repository
{
    /**
     * @return Collection<Role>
     */
    public function getAllowedForSignUp(): Collection
    {
        return $this
            ->newQuery()
            ->where(Role::FIELD_IS_ALLOWED_FOR_SIGN_UP, true)
            ->get();
    }
}
