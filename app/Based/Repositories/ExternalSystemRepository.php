<?php

namespace App\Based\Repositories;

use App\Based\Contracts\Repository;
use App\Based\Models\ExternalSystem;

class ExternalSystemRepository extends Repository
{
    public function findBySlug(string $slug): ?ExternalSystem
    {
        return $this
            ->newQuery()
            ->where(ExternalSystem::FIELD_SLUG, $slug)
            ->first();
    }
}
