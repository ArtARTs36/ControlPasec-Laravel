<?php

namespace App\Http\Resource;

use App\Models\Supply\SupplyProduct;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SupplyProductResource
 *
 * @mixin SupplyProduct
 */
class SupplyProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'product_id' => $this->product_id,
            'supply_id' => $this->supply_id,
            'product' => $this->product ?? null
        ];
    }
}
