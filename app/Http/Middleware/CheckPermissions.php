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
        $method = Route::current()->getActionMethod();
        $controller = get_class(Route::current()->controller);

        $response = $this->checkPermissions($method, $controller::PERMISSIONS);
        if ($response !== null) {
            return $response;
        }

        return $next($request);
    }

    /**
     * @param string $method
     * @param array $permissions
     * @return UserDoesNotHavePermission|null
     */
    private function checkPermissions(string $method, array $permissions)
    {
        if ((empty($permissions)) ||
            (empty($permissions[$method])) ||
            !($permission = $permissions[$method])) {
            return null;
        }

        /** @var User $user */
        $user = auth()->user();

        if (!$user || !$user->hasApiPermission($permission)) {
            return new UserDoesNotHavePermission($permission);
            //throw new UnauthorizedException();
        }

        return null;
    }
}
