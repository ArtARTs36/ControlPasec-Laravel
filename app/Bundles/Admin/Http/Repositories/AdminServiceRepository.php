<?php

namespace App\Bundles\Admin\Http\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Admin\Models\AdminService;

class AdminServiceRepository extends Repository
{
    public function findByName(string $name): ?AdminService
    {
        return $this->newQuery()->where(AdminService::FIELD_NAME, $name)->first();
    }
}
