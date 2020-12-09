<?php

namespace App\Bundles\Supply\Http\Resources;

use App\Models\Supply\Supply;
use App\Bundles\Supply\Services\SupplyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SupplyResource
 *
 * @mixin Supply
 * @extends JsonResource<Supply>
 *
 * @OA\Schema(type="object")
 */
class SupplyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     *
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="customer", type="object")
     * @OA\Property(property="totalPrice", type="float")
     * @OA\Property(property="planned_date", type="string")
     * @OA\Property(property="execute_date", type="string")
     * @OA\Property(property="products", type="string")
     * @OA\Property(property="contract", type="ContractResource")
     * @OA\Property(property="contract_id", type="integer")
     */
    public function toArray($request): array
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
