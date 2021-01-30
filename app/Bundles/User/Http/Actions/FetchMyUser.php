<?php

namespace App\Bundles\User\Http\Actions;

use App\Bundles\User\Http\Resources\UserResource;
use App\User;

class FetchMyUser
{
    public function toResource(): UserResource
    {
        return new UserResource($this->fullLoad($this->getUserOrAbort()));
    }

    private function fullLoad(User $user): User
    {
        if ($user->getAttributeValue('notifications') === null) {
            $user->load(User::RELATION_UNREAD_NOTIFICATIONS);
        }

        return $user;
    }

    private function getUserOrAbort(): User
    {
        if (auth()->guest()) {
            abort(403);
        }

        return auth()->user();
    }
}
