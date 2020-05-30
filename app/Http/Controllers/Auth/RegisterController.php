<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\UserRegisteredResponse;
use App\Models\User\Role;
use App\Repositories\UserRepository;
use App\User;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param UserRegisterRequest $request
     * @return UserRegisteredResponse
     */
    public function store(UserRegisterRequest $request): UserRegisteredResponse
    {
        $role = Role::query()->find($request->role_id);
        if ($role === null || $role->isNotAllowedForSignUp()) {
            return new UserRegisteredResponse(false, 'Роль недоступна для регистрации');
        }

        event(new UserRegistered($this->create($request->toArray(), $role)));

        return new UserRegisteredResponse(true);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param Role $role
     * @return User
     */
    private function create(array $data, Role $role): User
    {
        return UserRepository::create($data)->attachRole($role);
    }
}
