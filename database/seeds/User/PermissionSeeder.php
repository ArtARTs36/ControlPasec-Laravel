<?php

use App\Models\User\Permission;

class PermissionSeeder extends CommonSeeder
{
    public function run()
    {
        $list = [];
        foreach (Permission::getAllNames() as $name) {
            $list[] = [
                'name' => $name,
                'guard_name' => 'api'
            ];
        }

        Permission::insert($list);
    }
}
