<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    public function getRolesForSignUp()
    {
        return RoleRepository::getAllowedForSignUp();
    }
}
