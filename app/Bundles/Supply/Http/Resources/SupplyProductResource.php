<?php

namespace App\Bundles\Supply\Http\Resources;

use App\Bundles\Supply\Models\SupplyProduct;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SupplyProductResource
 *
 * @mixin SupplyProduct
 * @extends JsonResource<SupplyProduct>
 */
class SupplyProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'product_id' => $this->product_id,
            'supply_id' => $this->supply_id,
            'product' => $this->parent ?? null,
            'gos_standard' => $this->parent->gosStandard ?? null
        ];
    }
}
