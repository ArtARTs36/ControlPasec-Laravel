<?php

namespace App\Http\Resource;

use App\Bundles\User\Services\DialogMessageService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin User
 * @extends JsonResource<User>
 *
 * @OA\Schema(type="object")
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     *
     * @OA\Property(property="id", type="integer")
     */
    public function toArray($request): array
    {
        $messages = $this->recievedUnReadDialogMessages;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'family' => $this->family,
            'position' => $this->position,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->getPermissionsViaRoles()),
            'notifications' => UserNotificationResource::collection($this->whenLoaded('unreadNotifications')),
            'notifications_unread_count' => $this->getUnreadNotificationsCount(),
            'avatar_url' => $this->getAvatarUrl(),
            'is_active' => $this->is_active,
            'email' => $this->email,
            'messages' => UserReceivedMessagesCutResource::collection($messages),
            'messages_unread_count' => DialogMessageService::bringUnReadCount($messages),
        ];
    }
}
