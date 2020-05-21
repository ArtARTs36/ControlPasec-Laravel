<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resource\UserResource;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::USERS_LIST_VIEW,
        'show' => Permission::USERS_VIEW,
        'store' => Permission::USERS_CREATE,
        'activate' => Permission::USERS_ACTIVATE,
        'deactivate' => Permission::USERS_DEACTIVATE,
    ];

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
        if (auth()->user() === null) {
            abort(403);
        }

        return new UserResource(auth()->user());
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return User::latest('created_at')
            ->paginate(10, ['*'], 'UsersList', $page);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user): ActionResponse
    {
        return new ActionResponse($user->update($request->all()), new UserResource($user));
    }

    public function store(UserRequest $request): ActionResponse
    {
        $user = User::create(array_merge(
            $request->toArray(),
            [
                'is_active' => false,
                'password' => Hash::make($request->password),
            ]
        ));

        return new ActionResponse(true, $user);
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
        $user->roles()->attach($role->id);

        return new ActionResponse(true, new UserResource($user));
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
