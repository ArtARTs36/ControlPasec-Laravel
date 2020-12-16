<?php

namespace App\Based\Events;

final class ExceptionNotified extends Event
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
