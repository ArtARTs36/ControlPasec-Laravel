<?php

namespace App\Based\Events;

use App\Based\Events\BaseEvent;

final class ExceptionNotified extends BaseEvent
{
    private $exception;

    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
    }

    public function getException(): \Throwable
    {
        return $this->exception;
    }
}
