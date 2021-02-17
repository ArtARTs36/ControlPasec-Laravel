<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Bundles\Admin\Http\Resources\ServiceRedirectResource;
use App\Bundles\Admin\Repositories\AdminServiceRepository;
use App\Bundles\User\Models\Role;
use App\Based\Contracts\Controller;
use Illuminate\Http\Request;

final class AdminServiceController extends Controller
{
    private $repository;

    public function __construct(AdminServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @tag AdminService
     */
    public function redirect(string $name, Request $request): ServiceRedirectResource
    {
        if (! ($user = $this->getUser()) || ! $user->hasRole(Role::ADMIN)) {
            abort(403);
        }

        if (! ($service = $this->repository->findByName($name))) {
            abort(404);
        }

        $service->access()->give($request->getClientIp());

        return new ServiceRedirectResource($service);
    }
}
