<?php

namespace App\Services\Go;

/**
 * Class GoProgram
 *
 * @todo уйти от execute()
 */
abstract class GoProgram
{
    /** @var string  */
    const NAME = 'GoProgram';

    /** @var bool */
    const IS_BINARY = false;

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
            $this->executor = new GoProgramExecutor(static::NAME, null, static::IS_BINARY);
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
