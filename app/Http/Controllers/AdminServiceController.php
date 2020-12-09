<?php

namespace App\Http\Controllers;

use App\Http\Resource\AdminService\AdminServiceRedirectResource;
use App\Bundles\Admin\Models\AdminService;
use App\Bundles\User\Models\Role;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    /**
     * @param string $name
     * @param Request $request
     * @return AdminServiceRedirectResource
     */
    public function redirect(string $name, Request $request): AdminServiceRedirectResource
    {
        if (!($user = auth()->user()) || !$user->hasRole(Role::ADMIN)) {
            abort(403);
        }

        /** @var AdminService $service */
        $service = AdminService::query()->where(AdminService::FIELD_NAME, $name)->first();
        $service->access()->give($request->getClientIp());

        return new AdminServiceRedirectResource($service);
    }
}
