<?php

namespace App\Bundles\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowLog extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
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
