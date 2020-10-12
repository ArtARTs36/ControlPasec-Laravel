<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Repositories\RoleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class RoleController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::ROLE_LIST_VIEW,
    ];

    /**
     * Получить роли, доступные для регистрации
     * @return Collection
     */
    public function getRolesForSignUp(): Collection
    {
        return RoleRepository::getAllowedForSignUp();
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return Role::query()
            ->latest('id')
            ->paginate(10, ['*'], 'RolesList', $page);
    }

    /**
     * Разрешить регистрацию пользователя с ролью $role
     * @param Role $role
     * @return Role
     */
    public function attachAllowedForSignUp(Role $role): Role
    {
        return $role->changeAllowedForSignUp(true);
    }

    /**
     * Запретить регистрацию пользователя с ролью $role
     * @param Role $role
     * @return Role
     */
    public function detachAllowedForSignUp(Role $role): Role
    {
        return $role->changeAllowedForSignUp(false);
    }
}
