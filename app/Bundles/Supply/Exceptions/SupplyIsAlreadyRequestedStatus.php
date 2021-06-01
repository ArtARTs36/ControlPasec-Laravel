<?php

namespace App\Bundles\Supply\Exceptions;

use App\Bundles\Supply\Models\SupplyStatus;
use Throwable;

class SupplyIsAlreadyRequestedStatus extends \Exception
{
    public function __construct(SupplyStatus $status, $code = 0, ?Throwable $previous = null)
    {
        $message = 'Поставка уже находится на статусе "'. $status->title . '"';

        parent::__construct($message, $code, $previous);
    }
}
