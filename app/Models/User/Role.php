<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * Class Role
 * @property bool $is_allowed_for_sign_up
 * @mixin Builder
 */
class Role extends BaseRole
{
    public function isNotAllowedForSignUp(): bool
    {
        return $this->is_allowed_for_sign_up === false;
    }
}
