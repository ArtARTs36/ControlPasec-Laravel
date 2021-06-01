<?php

namespace App\Bundles\User\Services;

use App\Based\Support\Avatar;
use App\Bundles\User\Events\UserRegistered;
use App\Bundles\User\Models\Role;
use App\Bundles\User\Repositories\RoleRepository;
use App\Bundles\User\Repositories\UserRepository;
use App\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    private $users;

    private $roles;

    private $events;

    public function __construct(UserRepository $users, RoleRepository $roles, Dispatcher $events)
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->events = $events;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function registerByRoleId(array $data, int $roleId): User
    {
        $role = $this->roles->find($roleId);

        if ($role === null) {
            throw new \LogicException('Роль недоступна для регистрации');
        }

        return $this->register($data, $role);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function register(array $data, Role $role): User
    {
        if ($role->isNotAllowedForSignUp()) {
            throw new \LogicException('Роль недоступна для регистрации', 409);
        }

        $user = $this->users->create(array_merge(
            $data,
            [
                'is_active' => false,
                'password' => Hash::make($data['password']),
                'avatar_url' => Avatar::random(),
            ]
        ))->attachRole($role);

        $this->events->dispatch(new UserRegistered($user));

        return $user;
    }
}
