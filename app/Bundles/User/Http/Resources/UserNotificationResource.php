<?php

namespace App\Bundles\User\Http\Resources;

use App\Bundles\User\Models\UserNotification;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserNotificationResource
 * @mixin UserNotification
 * @extends JsonResource<UserNotification>
 */
class UserNotificationResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'type' => [
                'name' => $this->type->name,
            ],
            'is_read' => $this->is_read,
            'about_model_id' => $this->about_model_id,
        ];
    }
}
