<?php

namespace App\Services\Shell;

class ShellCommandCutOption extends ShellCommandOption
{
    /**
     * @return string
     */
    public function getString(): string
    {
        return '-'. $this->option . ($this->value ? '=' . $this->value : '');
    }
}
