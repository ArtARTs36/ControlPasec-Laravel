<?php

namespace App\Bundles\Admin\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Admin\Models\SystemSnapshot;
use Illuminate\Support\Collection;

class SystemSnapshotRepository extends Repository
{
    public function all(): Collection
    {
        return $this->newQuery()->orderByDesc(SystemSnapshot::CREATED_AT)->get();
    }
}
