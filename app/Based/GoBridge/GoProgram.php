<?php

namespace App\Based\GoBridge;

abstract class GoProgram
{
    public const NAME = 'GoProgram';

    protected const IS_BINARY = false;

    /** @var Executor  */
    private $executor;

    public function getExecutor(): Executor
    {
        if ($this->executor === null) {
            $this->executor = new Executor(static::NAME, null, static::IS_BINARY);
        }

        return $this->executor;
    }
}
