<?php

namespace App\Events;

/**
 * Class ExceptionNotified
 * @package App\Events
 */
class ExceptionNotified extends BaseEvent
{
    /** @var \Exception  */
    public $exception;

    /**
     * ExceptionNotified constructor.
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }
}
