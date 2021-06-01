<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransitionRule;
use Illuminate\Support\Collection;

class SupplyStatusTransitionRuleRepository extends Repository
{
    public function exists(int $fromStatusId, int $toStatusId): bool
    {
        return $this->newQuery()
            ->where(SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID, $fromStatusId)
            ->where(SupplyStatusTransitionRule::FIELD_TO_STATUS_ID, $toStatusId)
            ->exists();
    }

    public function create(SupplyStatus $fromStatus, SupplyStatus $toStatus): SupplyStatusTransitionRule
    {
        return $this->newQuery()->create([
            SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID => $fromStatus->id,
            SupplyStatusTransitionRule::FIELD_TO_STATUS_ID => $toStatus->id,
            SupplyStatusTransitionRule::CREATED_AT => new \DateTime(),
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
