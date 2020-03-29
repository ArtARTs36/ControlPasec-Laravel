<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\UserRegisteredResponse;
use App\Models\User\Role;
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

        $user = $this->create($request->toArray());

        event(new UserRegistered($user));

        return new UserRegisteredResponse(true);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'patronymic' => $data['patronymic'],
            'family' => $data['family'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => false, // @business-logic
        ]);

        $user->roles()->attach($data['role_id']);

        return $user;
    }
}
