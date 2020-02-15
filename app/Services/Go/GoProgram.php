<?php

namespace App\Services\Go;

abstract class GoProgram
{
    /** @var string  */
    const NAME = 'GoProgram';

    /** @var GoProgramExecutor  */
    private $executor;

    /**
     * @return mixed
     */
    abstract protected function process();

    /**
     * @return mixed
     */
    abstract protected function response();

    /**
     * @return GoProgramExecutor
     */
    public function getExecutor()
    {
        if ($this->executor === null) {
            $this->executor = new GoProgramExecutor(static::NAME);
        }

        return $this->executor;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $this->process();

        $this->executor->execute();

        return $this->response();
    }
}

