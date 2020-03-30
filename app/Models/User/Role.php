<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * Class Role
 * @property int $id
 * @property bool $is_allowed_for_sign_up
 * @property string $title
 * @property string $name
 * @mixin Builder
 */
final class Role extends BaseRole
{
    const ADMIN = 'admin';

    public function isNotAllowedForSignUp(): bool
    {
        return $this->is_allowed_for_sign_up === false;
    }
}
