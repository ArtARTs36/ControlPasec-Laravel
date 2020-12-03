<?php

namespace App\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\User\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PermissionRepository extends Repository
{
    public static function findByName(string $name): ?Permission
    {
        return Permission::query()->where(Permission::FIELD_NAME, $name)->first();
    }

    public function paginate(int $page): LengthAwarePaginator
    {
        return Permission::latest('id')
            ->paginate(10, ['*'], 'PermissionsList', $page);
    }
}
