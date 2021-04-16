<?php

namespace App\Bundles\Contragent\Http\Resources;

use App\Bundles\Contragent\Models\ContragentGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ContragentGroup
 * @extends JsonResource<ContragentGroup>
 */
class ContragentGroupResource extends JsonResource
{
    public function toArray($request = null): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contragents' => $this->contragents
        ];
    }
}
