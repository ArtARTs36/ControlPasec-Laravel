<?php

class AdminServiceSeeder extends CommonSeeder
{
    public function run(): void
    {
        $this->fillModel(\App\Bundles\Admin\Models\AdminService::class, 'data_admin_services');
    }
}
