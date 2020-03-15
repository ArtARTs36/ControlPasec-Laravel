<?php

namespace App\Http\Resource;

use App\Models\Contract\Contract;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin User
 *
 * @OA\Schema(type="object")
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     *
     * @OA\Property(property="id", type="integer")
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'family' => $this->family,
            'position' => 'Position'
        ];
    }
}
