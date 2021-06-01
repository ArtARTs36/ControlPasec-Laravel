<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\Models\SupplyStatusTransitionRule;

class SupplyStatusTransitionRuleRepository extends Repository
{
    public function exists(int $fromStatusId, int $toStatusId): bool
    {
        return $this->newQuery()
            ->where(SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID, $fromStatusId)
            ->where(SupplyStatusTransitionRule::FIELD_TO_STATUS_ID, $toStatusId)
            ->exists();
    }
}
