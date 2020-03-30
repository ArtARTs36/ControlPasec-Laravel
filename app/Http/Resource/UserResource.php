<?php

namespace App\Http\Resource;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin User
 *
 * @OA\Schema(type="object")
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     *
     * @OA\Property(property="id", type="integer")
     */
    public function toArray($request): array
    {
        $permissions = Collection::make();
        foreach ($this->roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'family' => $this->family,
            'position' => $this->position,
            'roles' => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($permissions),
        ];
    }
}
