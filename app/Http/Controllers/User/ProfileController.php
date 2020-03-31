<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileSearchRequest;
use App\Http\Requests\Profile\UpdateAboutMeRequest;
use App\Http\Resource\ProfileResource;
use App\Repositories\UserRepository;
use App\User;

class ProfileController extends Controller
{
    public function show(User $profile): ProfileResource
    {
        return new ProfileResource($profile);
    }

    public function updateAboutMe(UpdateAboutMeRequest $request): ProfileResource
    {
        /** @var User $user */
        $user = auth()->user();

        $user->about_me = $request->about_me;
        $user->save();

        return new ProfileResource($user);
    }

    public function search(string $query)
    {
        $users = UserRepository::liveFind($query);

        return ProfileResource::collection($users);
    }
}
