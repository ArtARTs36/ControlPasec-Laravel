<?php

use App\Models\User\Permission;

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

        Permission::query()->insert($list);
    }
}
