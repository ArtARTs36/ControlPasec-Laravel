<?php

namespace App\Bundles\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PermissionController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::PERMISSIONS_LIST_VIEW,
    ];

    private $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }
}
