<?php

namespace App\Bundles\Admin\Models;

use App\Bundles\Admin\Support\ServiceAccess as AdminServiceAccess;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property bool $is_external
 * @property string $path
 */
class AdminService extends Model
{
    private $access = null;

    public const NAME_HORIZON = 'horizon';
    public const NAME_TOTEM = 'totem';

    public const FIELD_NAME = 'name';

    public function access(): ?AdminServiceAccess
    {
        if ($this->isSelf() && $this->access === null) {
            $this->access = new AdminServiceAccess($this);
        }

        return $this->access;
    }

    public function isSelf(): bool
    {
        return $this->is_external === false;
    }

    public function getUrl(): string
    {
        return ($this->isSelf() ? request()->getSchemeAndHttpHost() : '') .  $this->path;
    }
}
