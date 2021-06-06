<?php

namespace App\Bundles\Supply\DataObjects;

use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Models\SupplyStatusTransitionRule;
use App\User;

final class StatusesTransfer
{
    private $fromStatus;

    private $toStatus;

    private $user;

    private $comment;

    public function __construct(SupplyStatus $fromStatus, SupplyStatus $toStatus, User $user, string $comment)
    {
        $this->fromStatus = $fromStatus;
        $this->toStatus = $toStatus;
        $this->user = $user;
        $this->comment = $comment;
    }

    public static function fromRule(SupplyStatusTransitionRule $rule, User $user, string $comment): self
    {
        return new self($rule->fromStatus, $rule->toStatus, $user, $comment);
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}
