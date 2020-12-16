<?php

namespace App\Bundles\Supply\Http\Resources;

use App\Bundles\Supply\Models\Contract;
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
    public function toArray($request): array
    {
        return [
            'id' => $this->id
        ];
    }
}
