<?php

namespace App\Http\Middleware;

use App\Http\Responses\UserDoesNotHavePermission;
use App\User;
use Closure;
use Illuminate\Support\Facades\Route;

class CheckPermissions
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (($perms = const_value(Route::current()->controller, 'PERMISSIONS')) &&
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
    private function check(string $method, array $permissions)
    {
        if ((empty($permissions[$method])) || !($permission = $permissions[$method])) {
            return null;
        }

        /** @var User $user */
        if (($user = auth()->user()) || !$user->hasApiPermission($permission)) {
            return new UserDoesNotHavePermission($permission);
            //throw new UnauthorizedException();
        }

        return null;
    }
}
