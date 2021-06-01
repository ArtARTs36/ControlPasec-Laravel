<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\DataObjects\StatusesTransfer;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransition;
use App\User;

class SupplyStatusTransitionRepository extends Repository
{
    public function create(
        Supply $supply,
        StatusesTransfer $transfer,
        User $user
    ): SupplyStatusTransition {
        return $this->newQuery()->create([
            SupplyStatusTransition::FIELD_SUPPLY_ID => $supply->id,
            SupplyStatusTransition::FIELD_FROM_STATUS_ID => $transfer->getFromStatus()->id,
            SupplyStatusTransition::FIELD_TO_STATUS_ID => $transfer->getToStatus()->id,
            SupplyStatusTransition::FIELD_USER_ID => $user->id,
            SupplyStatusTransition::FIELD_EXECUTED_AT => new \DateTime(),
        ]);
    }

    public function createByStatus(Supply $supply, SupplyStatus $status, User $user): SupplyStatusTransition
    {
        return $this->newQuery()->create([
            SupplyStatusTransition::FIELD_SUPPLY_ID => $supply->id,
            SupplyStatusTransition::FIELD_TO_STATUS_ID => $status->id,
            SupplyStatusTransition::FIELD_USER_ID => $user->id,
            SupplyStatusTransition::FIELD_EXECUTED_AT => new \DateTime(),
        ]);
    }
}
