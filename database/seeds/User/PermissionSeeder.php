<?php

use App\Bundles\User\Models\Permission;

class PermissionSeeder extends CommonSeeder
{
    public function run()
    {
        $list = [];
        foreach (Permission::getAllNames() as $name => $title) {
            $list[] = [
                'name' => $name,
                'title' => $title,
                'guard_name' => 'api',
            ];
        }

        Permission::insert($list);
    }
}
