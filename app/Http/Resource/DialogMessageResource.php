<?php

namespace App\Http\Resource;

use App\Bundles\User\Models\DialogMessage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DialogMessageResource
 * @mixin DialogMessage
 * @extends JsonResource<DialogMessage>
 */
class DialogMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from_user_id' => $this->from_user_id,
            'to_user_id' => $this->to_user_id,
            'text' => $this->text,
            'updated_at' => (new \DateTime($this->updated_at))->format('d.m.y H:i'),
            'is_my_user_author' => $this->isCurrentUserAuthor(),
        ];
    }
}
