<?php

namespace App\Http\Resource;

use App\Models\Supply\Supply;
use App\Services\SupplyService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SupplyResource
 *
 * @mixin Supply
 */
class SupplyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => $this->customer,
            'customer_id' => $this->customer_id,
            'totalPrice' => SupplyService::bringTotalPriceByProducts($this->products),
            'planned_date' => $this->planned_date,
            'execute_date' => $this->execute_date,
            'products' => $this->products,
            'contract' => $this->contract,
            'contract_id' => $this->contract_id
        ];
    }
}
