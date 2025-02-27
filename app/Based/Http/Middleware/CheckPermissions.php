<?php

namespace App\Based\Http\Middleware;

use App\Bundles\User\Http\Responses\UserDoesNotHavePermission;
use App\Bundles\User\Repositories\PermissionRepository;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckPermissions
{
    protected $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controller = Route::current()->controller;

        if (const_exists($controller, 'PERMISSIONS') &&
            ($perms = $controller::PERMISSIONS) &&
            ($response = $this->check(Route::current()->getActionMethod(), $perms))) {
            return $response;
        }

        return $next($request);
    }

    /**
     * @param string $method
     * @param array $permissions
     * @return UserDoesNotHavePermission|null
     */
    private function check(string $method, array $permissions): ?UserDoesNotHavePermission
    {
        if ((empty($permissions[$method])) || !($permission = $permissions[$method])) {
            return null;
        }

        /** @var User|null $user */
        $user = auth()->user();

        if ($user === null || ! $user->hasApiPermission($permission)) {
            return new UserDoesNotHavePermission($this->repository->findByName($permission));
        }

        return null;
    }
}
