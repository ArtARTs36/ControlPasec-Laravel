<?php

namespace App\Bundles\Admin\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Admin\Models\AdminService;

final class AdminServiceRepository extends Repository
{
    public function findOrFail(string $name): AdminService
    {
        return $this
            ->newQuery()
            ->where(AdminService::FIELD_NAME, $name)
            ->firstOrFail();
    }
}
