<?php

use App\Bundles\User\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(Role::class, 'data_roles');

        Role::findByName('admin')
            ->permissions()
            ->attach(Permission::all()->pluck('id'));
    }
}
