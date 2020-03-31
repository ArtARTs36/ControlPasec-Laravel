<?php

namespace App\Http\Resource;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileResource
 * @mixin User
 */
class ProfileResource extends JsonResource
{
    public function toArray($request)
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
