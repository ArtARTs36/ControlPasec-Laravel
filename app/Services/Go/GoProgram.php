<?php

namespace App\Services\Go;

abstract class GoProgram
{
    const GO_ROOT_DIR = __DIR__ . '/../../../go-programs';

    abstract protected function getShellScript();

    abstract protected function process();

    abstract protected function response();

    public function execute()
    {
        $this->process();

        shell_exec($this->getShellScript());

        return $this->response();
    }
}

