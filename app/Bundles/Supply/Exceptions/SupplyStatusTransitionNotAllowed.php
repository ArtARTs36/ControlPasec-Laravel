<?php

namespace App\Bundles\Supply\Exceptions;

use App\Bundles\Supply\Models\SupplyStatus;
use Throwable;

class SupplyStatusTransitionNotAllowed extends \LogicException
{
    public function __construct(SupplyStatus $fromStatus, SupplyStatus $toStatus, $code = 0, Throwable $previous = null)
    {
        $message = "Переход со статуса $fromStatus->title на статус $toStatus->title не возможен";

        parent::__construct($message, $code, $previous);
    }
}
