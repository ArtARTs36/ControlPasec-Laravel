<?php

namespace App\Bundles\Supply\Handlers;

use App\Bundles\Supply\Events\SupplyCreated;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Repositories\SupplyStatusRepository;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRepository;

class CreateTransitionForNewSupply
{
    protected $statuses;

    protected $transitions;

    public function __construct(SupplyStatusRepository $statuses, SupplyStatusTransitionRepository $transitions)
    {
        $this->statuses = $statuses;
        $this->transitions = $transitions;
    }

    public function handle(SupplyCreated $event): void
    {
        $this->transitions->createByStatus(
            $event->supply,
            $this->statuses->findBySlug(SupplyStatus::SLUG_NEW),
            $event->creator
        );
    }
}
