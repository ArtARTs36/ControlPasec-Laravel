<?php

namespace App\Based\Events;

use App\Events\Event;

class ExceptionNotified extends Event
{
    public $exception;

    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
    }
}
