<?php

namespace App\Repositories;

use App\Models\User\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository
{
    /**
     * @param string $name
     * @return Permission
     */
    public static function findByName(string $name): ?Permission
    {
        return Permission::query()->where(Permission::FIELD_NAME, $name)->first();
    }
}
