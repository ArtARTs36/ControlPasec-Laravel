<?php

namespace App\Bundles\Supply\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Supply\DataObjects\StatusesTransfer;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransition;
use App\User;
use Illuminate\Support\Collection;

class SupplyStatusTransitionRepository extends Repository
{
    public function create(
        Supply $supply,
        StatusesTransfer $transfer
    ): SupplyStatusTransition {
        return $this->newQuery()->create([
            SupplyStatusTransition::FIELD_SUPPLY_ID => $supply->id,
            SupplyStatusTransition::FIELD_FROM_STATUS_ID => $transfer->getFromStatus()->id,
            SupplyStatusTransition::FIELD_TO_STATUS_ID => $transfer->getToStatus()->id,
            SupplyStatusTransition::FIELD_USER_ID => $transfer->getUser()->id,
            SupplyStatusTransition::FIELD_EXECUTED_AT => new \DateTime(),
            SupplyStatusTransition::FIELD_COMMENT => $transfer->getComment(),
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

    /**
     * @return Collection|iterable<SupplyStatusTransition>
     */
    public function getBySupply(Supply $supply): Collection
    {
        return $this
            ->newQuery()
            ->where(SupplyStatusTransition::FIELD_SUPPLY_ID, $supply->id)
            ->with([
                SupplyStatusTransition::RELATION_FROM_STATUS,
                SupplyStatusTransition::RELATION_TO_STATUS,
                SupplyStatusTransition::RELATION_USER,
            ])
            ->get();
    }
}
