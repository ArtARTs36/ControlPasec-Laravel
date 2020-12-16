<?php

namespace App\Bundles\Admin\Http\Resources;

use App\Bundles\Admin\Models\AdminService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AdminServiceRedirectResource
 * @mixin AdminService
 * @extends JsonResource<AdminService>
 */
class ServiceRedirectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'service_url' => $this->getUrl(),
            'service_name' => $this->name,
        ];
    }
}
