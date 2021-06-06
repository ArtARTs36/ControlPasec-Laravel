<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Supply\DataObjects\StatusesTransfer;
use App\Bundles\Supply\Exceptions\SupplyIsAlreadyRequestedStatus;
use App\Bundles\Supply\Exceptions\SupplyStatusTransitionNotAllowed;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyStatusTransition;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRepository;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;

class SupplyStatusChanger
{
    protected $rules;

    protected $transitions;

    public function __construct(SupplyStatusTransitionRuleRepository $rules, SupplyStatusTransitionRepository $transitions)
    {
        $this->rules = $rules;
        $this->transitions = $transitions;
    }

    /**
     * @throws SupplyIsAlreadyRequestedStatus
     */
    public function change(Supply $supply, StatusesTransfer $transfer): SupplyStatusTransition
    {
        // Статусы совпадают, не даем совершить переход
        if ($transfer->isStatusesEquals()) {
            throw new SupplyIsAlreadyRequestedStatus($transfer->getToStatus());
        }

        // Правило перехода - отсуствует
        if (! $this->rules->exists($supply->status_id, $transfer->getToStatus()->id)) {
            throw new SupplyStatusTransitionNotAllowed($supply->status, $transfer->getToStatus());
        }

        return $this->transition($supply, $transfer);
    }

    protected function transition(Supply $supply, StatusesTransfer $transfer): SupplyStatusTransition
    {
        // Устанвливаем новый статус
        $supply->status()->associate($transfer->getToStatus());
        $supply->save();

        // Создаем переход
        return $this->transitions->create($supply, $transfer);
    }
}
