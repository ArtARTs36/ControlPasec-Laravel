<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Supply\DataObjects\StatusesTransfer;
use App\Bundles\Supply\Exceptions\SupplyIsAlreadyRequestedStatus;
use App\Bundles\Supply\Exceptions\SupplyStatusTransitionNotAllowed;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransition;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRepository;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;
use App\User;

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
    public function change(Supply $supply, SupplyStatus $toStatus, User $user): SupplyStatusTransition
    {
        $transfer = new StatusesTransfer($supply->status, $toStatus);

        // Статусы совпадают, не даем совершить переход
        if ($transfer->isStatusesEquals()) {
            throw new SupplyIsAlreadyRequestedStatus($toStatus);
        }

        // Правило перехода - отсуствует
        if ($this->rules->exists($supply->status_id, $toStatus->id)) {
            throw new SupplyStatusTransitionNotAllowed($supply->status, $toStatus);
        }

        // Устанвливаем новый статус
        $supply->status()->associate($toStatus);

        // Создаем переход
        return $this->transitions->create($supply, $transfer, $user);
    }
}
