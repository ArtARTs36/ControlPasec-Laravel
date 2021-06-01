<?php

namespace App\Bundles\Supply\DataObjects;

use App\Bundles\Supply\Models\SupplyStatus;

final class StatusesTransfer
{
    private $fromStatus;

    private $toStatus;

    public function __construct(SupplyStatus $fromStatus, SupplyStatus $toStatus)
    {
        $this->fromStatus = $fromStatus;
        $this->toStatus = $toStatus;
    }

    public function getFromStatus(): SupplyStatus
    {
        return $this->fromStatus;
    }

    public function getToStatus(): SupplyStatus
    {
        return $this->toStatus;
    }

    public function isStatusesEquals(): bool
    {
        return $this->fromStatus->id === $this->toStatus->id;
    }
}
