<?php

namespace App\Bundles\Contragent\Http\Resources;

use App\Models\Contragent\ContragentGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ContragentGroupResource
 *
 * @mixin ContragentGroup
 * @extends JsonResource<ContragentGroup>
 */
class ContragentGroupResource extends JsonResource
{
    public function toArray($request = null)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'contragents' => $this->contragents
        ];
    }
}
