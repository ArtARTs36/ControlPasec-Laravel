<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\UserRegisteredResponse;
use App\Models\User\Role;
use App\Support\Avatar;
use App\User;
use Illuminate\Support\Facades\Hash;

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

    public function store(UserRegisterRequest $request)
    {
        $role = Role::find($request->role_id);
        if ($role === null || $role->isNotAllowedForSignUp()) {
            return new UserRegisteredResponse();
        }

        $user = $this->create($request->toArray(), $role);

        event(new UserRegistered($user));

        return new UserRegisteredResponse(true);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @param Role $role
     * @return User
     */
    public function create(array $data, Role $role): User
    {
        $user = User::create([
            'name' => $data['name'],
            'patronymic' => $data['patronymic'],
            'family' => $data['family'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => false, // @business-logic
            'position' => $role->title,
            'avatar_url' => Avatar::random(),
        ]);

        $user->roles()->attach($role->id);

        return $user;
    }
}
