<?php

namespace App\Support\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'message' => $this->prepareMessage(),
            'level_name' => $this->resource->level_name,
            'datetime' => $this->resource->datetime,
        ];
    }

    private function prepareMessage()
    {
        return $this->resource->message = explode("\n", $this->resource->message);
    }
}
