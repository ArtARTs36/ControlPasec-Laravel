<?php

use Spatie\Permission\Models\Role;

class RoleSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(Role::class, 'data_roles');
    }
}
