<?php

namespace App\Http\Resource;

use App\Models\User\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionResource
 * @mixin Permission
 */
class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
