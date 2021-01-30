<?php

namespace App\Bundles\User\Models;

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
    public const ADMIN = 'admin';

    public const FIELD_ID = 'id';
    public const FIELD_TITLE = 'title';
    public const FIELD_NAME = 'name';
    public const FIELD_IS_ALLOWED_FOR_SIGN_UP = 'is_allowed_for_sign_up';

    /**
     * @return bool
     */
    public function isNotAllowedForSignUp(): bool
    {
        return $this->is_allowed_for_sign_up === false;
    }

    /**
     * @param bool|null $state
     * @return $this
     */
    public function changeAllowedForSignUp(bool $state = null): self
    {
        $this->is_allowed_for_sign_up = ($state === null) ? !$this->is_allowed_for_sign_up : $state;
        $this->save();

        return $this;
    }
}
