<?php

namespace App\Http\Resource;

use App\Models\Dialog\Dialog;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DialogResource
 * @mixin Dialog
 */
class DialogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'messages' => DialogMessageResource::collection($this->messages),
        ];
    }
}
