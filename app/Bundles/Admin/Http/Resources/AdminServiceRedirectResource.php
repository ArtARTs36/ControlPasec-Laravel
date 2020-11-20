<?php

namespace App\Http\Resource\AdminService;

use App\Models\AdminService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AdminServiceRedirectResource
 * @mixin AdminService
 * @extends JsonResource<AdminService>
 */
class AdminServiceRedirectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'service_url' => $this->getUrl(),
            'service_name' => $this->name,
        ];
    }
}
