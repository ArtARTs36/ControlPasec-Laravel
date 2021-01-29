<?php

namespace App\Bundles\Plant\Http\Resources;

use App\Bundles\Plant\Models\Plant;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Plant
 */
class PlantIndexShow extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => [
                'id' => $this->category_id,
                'name' => $this->category->name,
            ],
        ];
    }
}
