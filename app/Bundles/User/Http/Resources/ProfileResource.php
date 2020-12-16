<?php

namespace App\Bundles\User\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileResource
 * @mixin User
 * @extends JsonResource<User>
 */
class ProfileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'patronymic' => $this->patronymic,
            'family' => $this->family,
            'position' => $this->position,
            'avatar_url' => $this->getAvatarUrl(),
            'email' => $this->email,
            'about_me' => $this->about_me,
            'days' => $this->getDays(),
        ];
    }
}
