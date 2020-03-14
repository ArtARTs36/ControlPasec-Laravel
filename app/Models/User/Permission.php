<?php

namespace App\Models\User;

use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * Class Permission
 * @mixin Builder
 */
final class Permission extends BasePermission
{
    const SUPPLIES_VIEW = 'supplies_view';
    const SUPPLIES_CREATE = 'supplies_create';

    public static function getAllNames()
    {
        return [
            self::SUPPLIES_VIEW,
            self::SUPPLIES_CREATE,
        ];
    }
}
