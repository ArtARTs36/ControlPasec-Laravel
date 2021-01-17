<?php

namespace App\Bundles\Plant\Http\Resources;

use App\Bundles\Plant\Models\Plant;
use ArtARTs36\RuSpelling\Month;
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
            'bloom_start_date' => $this->bloom_start_day . ' ' . Month::getGenitiveName($this->bloom_start_month),
            'bloom_end_date' => $this->bloom_end_day . ' ' . Month::getGenitiveName($this->bloom_end_month),
        ];
    }
}
