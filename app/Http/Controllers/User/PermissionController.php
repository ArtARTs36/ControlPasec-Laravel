<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionController extends Controller
{
    public function index($page = 1): LengthAwarePaginator
    {
        return Permission::latest('id')
            ->paginate(10, ['*'], null, $page);
    }
}
