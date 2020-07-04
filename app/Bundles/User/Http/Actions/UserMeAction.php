<?php

namespace App\Bundles\User\Http\Actions;

use App\Http\Resource\UserResource;
use App\User;

class UserMeAction
{
    public static function get(): UserResource
    {
        /** @var User $user */
        if (($user = auth()->user()) === null) {
            abort(403);
        }

        static::fullLoad($user);

        return new UserResource($user);
    }

    private static function fullLoad(User $user): void
    {
        if (!$user->getAttributeValue(User::RELATION_NOTIFICATIONS)) {
            $user->load(User::RELATION_UNREAD_NOTIFICATIONS);
        }
    }
}
