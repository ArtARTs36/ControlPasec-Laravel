<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransitionRule;
use Illuminate\Support\Collection;

class SupplyStatusTransitionRuleRepository extends Repository
{
    public function getAllWithRelations(): Collection
    {
        return $this
            ->newQuery()
            ->with(SupplyStatusTransitionRule::RELATION_TO_STATUS)
            ->with(SupplyStatusTransitionRule::RELATION_FROM_STATUS)
            ->orderBy(SupplyStatusTransitionRule::FIELD_ID)
            ->get();
    }

    public function exists(int $fromStatusId, int $toStatusId): bool
    {
        return $this->newQuery()
            ->where(SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID, $fromStatusId)
            ->where(SupplyStatusTransitionRule::FIELD_TO_STATUS_ID, $toStatusId)
            ->orderBy(SupplyStatusTransitionRule::FIELD_ID)
            ->exists();
    }

    public function create(?SupplyStatus $fromStatus, SupplyStatus $toStatus, string $title): SupplyStatusTransitionRule
    {
        return $this->newQuery()->create([
            SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID => $fromStatus ? $fromStatus->id : null,
            SupplyStatusTransitionRule::FIELD_TO_STATUS_ID => $toStatus->id,
            SupplyStatusTransitionRule::CREATED_AT => new \DateTime(),
            SupplyStatusTransitionRule::FIELD_TITLE => $title,
        ]);
    }

    /**
     * @return Collection|iterable<SupplyStatusTransitionRule>
     */
    public function all(): Collection
    {
        return $this->newQuery()->get();
    }
}
