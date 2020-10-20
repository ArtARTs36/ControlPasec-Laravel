<?php

namespace App\Bundles\Contract\Http\Resources;

use App\Bundles\Contract\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ContractResource
 *
 * @mixin Contract
 * @extends JsonResource<Contract>
 *
 * @OA\Schema(type="object")
 */
class ContractResource extends JsonResource
{
    /**
     * @param Request $request
     * @OA\Property(property="id", type="integer")
     * @OA\Property(property="customer", type="object")
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id
        ];
    }
}
