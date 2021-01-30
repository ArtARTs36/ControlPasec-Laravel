<?php

namespace App\Bundles\User\Http\Responses;

use App\Bundles\User\Models\Permission;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserDoesNotHavePermission extends JsonResponse
{
    /**
     * UserDoesNotHavePermission constructor.
     * @param Permission|string $permission
     */
    public function __construct($permission)
    {
        if (! $permission instanceof Permission) {
            $permission = Permission::findByName($permission);
        }

        parent::__construct([
            'message' => 'У Вас нет доступа',
            'permission' => $permission->title,
        ], Response::HTTP_FORBIDDEN, [], 0);
    }
}
