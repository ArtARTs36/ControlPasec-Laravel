<?php

namespace App\Bundles\User\Http\Actions;

use App\Bundles\User\Http\Resources\UserResource;
use App\User;

class FetchMyUser
{
    public function toResource(): UserResource
    {
        /** @var User $user */
        if (($user = auth()->user()) === null) {
            abort(403);
        }

        static::fullLoad($user);

        return new UserResource($user);
    }

    private function fullLoad(User $user): void
    {
        if ($user->getAttributeValue('notifications') === null) {
            $user->load(User::RELATION_UNREAD_NOTIFICATIONS);
        }
    }
}
