<?php

namespace App\Http\Resource;

use App\Models\User\UserNotification;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserNotificationResource
 * @mixin UserNotification
 */
class UserNotificationResource extends JsonResource
{
    public function toArray($request)
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
