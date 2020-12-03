<?php

namespace App\Http\Resource;

use App\Bundles\User\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RoleResource
 * @mixin Role
 * @extends JsonResource<Role>
 */
class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
        ];
    }
}
