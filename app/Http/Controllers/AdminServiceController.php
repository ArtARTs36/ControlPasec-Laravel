<?php

namespace App\Http\Controllers;

use App\Bundles\Admin\Http\Resources\ServiceRedirectResource;
use App\Bundles\Admin\Models\AdminService;
use App\Bundles\User\Models\Role;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    /**
     * @param string $name
     * @param Request $request
     * @return ServiceRedirectResource
     */
    public function redirect(string $name, Request $request): ServiceRedirectResource
    {
        if (!($user = auth()->user()) || !$user->hasRole(Role::ADMIN)) {
            abort(403);
        }

        /** @var AdminService $service */
        $service = AdminService::query()->where(AdminService::FIELD_NAME, $name)->first();
        $service->access()->give($request->getClientIp());

        return new ServiceRedirectResource($service);
    }
}
