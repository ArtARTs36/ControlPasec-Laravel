<?php

namespace App\Models;

use App\Services\AdminService\AdminServiceAccess;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminService
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property bool $is_external
 * @property string $path
 */
class AdminService extends Model
{
    /** @var AdminServiceAccess|null */
    private $access = null;

    public const NAME_HORIZON = 'horizon';
    public const NAME_TOTEM = 'totem';

    /** @var string */
    public const FIELD_NAME = 'name';

    /**
     * @return AdminServiceAccess|null
     */
    public function access(): ?AdminServiceAccess
    {
        if ($this->isSelf() && $this->access === null) {
            $this->access = new AdminServiceAccess($this);
        }

        return $this->access;
    }

    /**
     * @return bool
     */
    public function isSelf(): bool
    {
        return $this->is_external === false;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return ($this->isSelf() ? request()->getSchemeAndHttpHost() : '') .  $this->path;
    }

    /**
     * @param string $name
     * @param string $ip
     * @return bool
     */
    public static function isAllowed(string $name, string $ip): bool
    {
        return AdminService::query()
            ->where(AdminService::FIELD_NAME, $name)
            ->firstOrFail()
            ->access()
            ->isAllowed($ip);
    }
}
