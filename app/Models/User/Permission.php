<?php

namespace App\Models\User;

use Illuminate\Database\Query\Builder;
use Spatie\Permission\Models\Permission as BasePermission;

/**
 * Class Permission
 * @property int id
 * @property string name
 * @mixin Builder
 */
final class Permission extends BasePermission
{
    const SUPPLIES_VIEW = 'supplies_view';
    const SUPPLIES_CREATE = 'supplies_create';
    const SUPPLIES_EDIT = 'supplies_edit';

    const USERS_VIEW = 'users_view';
    const USERS_ACTIVATE = 'users_activate';
    const USERS_DEACTIVATE = 'users_deactivate';

    public static function getAllNames()
    {
        return [
            self::SUPPLIES_VIEW,
            self::SUPPLIES_CREATE,
            self::SUPPLIES_EDIT,
            self::USERS_VIEW,
            self::USERS_ACTIVATE,
            self::USERS_DEACTIVATE,
        ];
    }
}
