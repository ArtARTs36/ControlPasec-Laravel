<?php

namespace App\Bundles\User\Http\Controllers;

use App\Http\Actions\UserMeAction;
use App\Http\Controllers\Controller;
use App\Bundles\User\Http\Requests\StoreUser;
use App\Http\Resource\UserResource;
use App\Http\Responses\ActionResponse;
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
     *
     * @return UserResource
     *
     * @OA\Get(
     *      path="/api/me",
     *      operationId="User me Profile",
     *      tags={"Me Current User"},
     *      description="Get authenticated user meta",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Schema(ref="#/components/schemas/User"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function me()
    {
        return UserMeAction::get();
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @param StoreUser $request
     * @param User $user
     * @return ActionResponse
     */
    public function update(StoreUser $request, User $user): ActionResponse
    {
        return new ActionResponse($this->updateModel($request, $user), new UserResource($user));
    }

    /**
     * @param StoreUser $request
     * @return ActionResponse
     */
    public function store(StoreUser $request): ActionResponse
    {
        return new ActionResponse(true, $this->repository->create($request->toArray()));
    }

    /**
     * Открепить роль у пользователя
     * @param User $user
     * @param Role $role
     * @return ActionResponse
     */
    public function detachRole(User $user, Role $role): ActionResponse
    {
        return new ActionResponse($user->roles()->detach($role->id) > 0, new UserResource($user));
    }

    /**
     * Добавить роль пользователю
     * @param User $user
     * @param Role $role
     * @return ActionResponse
     */
    public function attachRole(User $user, Role $role): ActionResponse
    {
        return new ActionResponse(true, new UserResource($user->attachRole($role)));
    }

    /**
     * Активировать профиль пользователя
     * @param User $user
     * @return User
     */
    public function activate(User $user): User
    {
        return $user->changeActive(true);
    }

    /**
     * Деактивировать профиль пользователя
     * @param User $user
     * @return User
     */
    public function deactivate(User $user): User
    {
        return $user->changeActive(false);
    }
}
