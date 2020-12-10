<?php

namespace App\Bundles\User\Http\Controllers;

use App\Bundles\User\Http\Resources\ProfileResource;
use App\Based\Contracts\Controller;
use App\Bundles\User\Http\Requests\UpdateAboutMe;
use App\Bundles\User\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class ProfileController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(int $profileId): ProfileResource
    {
        $profile = $this->repository->findActive($profileId);

        if (null === $profile) {
            abort(Response::HTTP_CONFLICT, __('profile.not_found'));
        }

        return new ProfileResource($profile);
    }

    public function updateAboutMe(UpdateAboutMe $request): ProfileResource
    {
        /** @var User $user */
        $user = auth()->user();

        $user->about_me = $request->about_me;
        $user->save();

        return new ProfileResource($user);
    }

    public function search(string $query): AnonymousResourceCollection
    {
        return ProfileResource::collection($this->repository->liveFind($query));
    }
}
