<?php

namespace App\Bundles\Contragent\Http\Resources;

use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contragent
 */
class ShowContragent extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'full_title' => $this->full_title,
            'full_title_with_opf' => $this->full_title_with_opf,
        ];
    }
}
