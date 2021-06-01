<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\SupplyStatus;
use Illuminate\Support\Collection;

class SupplyStatusRepository extends Repository
{
    public function create(string $title, string $slug): SupplyStatus
    {
        return $this->newQuery()->create([
            SupplyStatus::FIELD_TITLE => $title,
            SupplyStatus::FIELD_SLUG => $slug,
        ]);
    }

    public function findBySlug(string $slug): SupplyStatus
    {
        return $this->newQuery()->where(SupplyStatus::FIELD_SLUG, $slug)->firstOrFail();
    }

    /**
     * @return Collection|iterable<SupplyStatus>
     */
    public function all(): Collection
    {
        return $this
            ->newQuery()
            ->get();
    }
}
