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

        if (!preg_match('/http/i', $this->avatar_url)) {
            $this->avatar_url = '//'. request()->getHttpHost() . $this->avatar_url;
        }

        $this->loadMissing('notifications');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'family' => $this->family,
            'position' => $this->position,
            'roles' => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($permissions),
            'notifications' => UserNotificationResource::collection($this->notifications),
            'notifications_unread_count' => $this->getUnreadNotificationsCount(),
            'avatar_url' => $this->avatar_url,
            'is_active' => $this->is_active,
            'email' => $this->email,
        ];
    }
}
