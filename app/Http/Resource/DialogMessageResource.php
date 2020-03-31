<?php

namespace App\Http\Resource;

use App\Models\Dialog\DialogMessage;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DialogMessageResource
 * @mixin DialogMessage
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
            'created_at' => $this->created_at,
        ];
    }
}
