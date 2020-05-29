<?php

namespace App\Repositories;

use App\Models\User\Permission;

class PermissionRepository
{
    /**
     * @param string $name
     * @return Permission
     */
    public static function findByName(string $name): Permission
    {
        return Permission::query()->where(Permission::FIELD_NAME, $name)->first();
    }
}
