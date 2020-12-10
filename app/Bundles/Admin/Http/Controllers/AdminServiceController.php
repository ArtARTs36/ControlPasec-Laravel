<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Bundles\Admin\Http\Resources\ServiceRedirectResource;
use App\Bundles\Admin\Models\AdminService;
use App\Bundles\User\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
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
