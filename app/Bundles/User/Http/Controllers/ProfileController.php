<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateAboutMeRequest;
use App\Http\Resource\ProfileResource;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function show(int $profileId): ProfileResource
    {
        $profile = User::where('id', $profileId)
            ->where('is_active', true)
            ->first();

        if (null === $profile) {
            abort(Response::HTTP_CONFLICT, __('profile.not_found'));
        }

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
