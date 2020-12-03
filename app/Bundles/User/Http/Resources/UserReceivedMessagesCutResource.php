<?php

namespace App\Bundles\User\Http\Resources;

use App\Bundles\User\Models\DialogMessage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserCutMessagesResource
 * @mixin DialogMessage
 * @extends JsonResource<DialogMessage>
 */
class UserReceivedMessagesCutResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'from' => $this->fromUser->getFullName(),
            'is_read' => $this->isRead()
        ];
    }
}
