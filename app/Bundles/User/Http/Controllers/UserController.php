<?php

namespace App\Bundles\User\Http\Controllers;

use App\Bundles\User\Http\Resources\UserResource;
use App\Bundles\User\Http\Actions\FetchMyUser;
use App\Based\Contracts\Controller;
use App\Bundles\User\Http\Requests\StoreUser;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\User\Models\Role;
use App\Bundles\User\Repositories\UserRepository;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class UserController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::USERS_LIST_VIEW,
        'show' => Permission::USERS_VIEW,
        'store' => Permission::USERS_CREATE,
        'activate' => Permission::USERS_ACTIVATE,
        'deactivate' => Permission::USERS_DEACTIVATE,
    ];

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @tag User
     */
    public function me(FetchMyUser $user): UserResource
    {
        return $user->toResource();
    }

    /**
     * @tag User
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @tag User
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @tag User
     */
    public function update(StoreUser $request, User $user): ActionResponse
    {
        return new ActionResponse($this->updateModel($request, $user), new UserResource($user));
    }

    /**
     * @tag User
     */
    public function store(StoreUser $request): ActionResponse
    {
        return new ActionResponse(true, $this->repository->create($request->toArray()));
    }

    /**
     * Открепить роль у пользователя
     * @tag User
     */
    public function detachRole(User $user, Role $role): ActionResponse
    {
        return new ActionResponse($user->roles()->detach($role->id) > 0, new UserResource($user));
    }

    /**
     * Добавить роль пользователю
     * @tag User
     */
    public function attachRole(User $user, Role $role): ActionResponse
    {
        return new ActionResponse(true, new UserResource($user->attachRole($role)));
    }

    /**
     * Активировать профиль пользователя
     * @tag User
     */
    public function activate(User $user): User
    {
        return $user->changeActive(true);
    }

    /**
     * Деактивировать профиль пользователя
     * @tag User
     */
    public function deactivate(User $user): User
    {
        return $user->changeActive(false);
    }
}
