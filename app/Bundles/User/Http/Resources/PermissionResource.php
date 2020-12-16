<?php

namespace App\Bundles\User\Http\Resources;

use App\Bundles\User\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionResource
 * @mixin Permission
 * @extends JsonResource<Permission>
 */
class PermissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
