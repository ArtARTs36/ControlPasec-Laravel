<?php

namespace App\Support\Log;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LogResource
 * @package App\Support\Log
 */
class LogResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'message' => $this->prepareMessage(),
            'level_name' => $this->resource->level_name,
            'datetime' => $this->resource->datetime,
        ];
    }

    /**
     * @return array
     */
    private function prepareMessage(): array
    {
        return explode("\n", $this->resource->message);
    }
}
