<?php

namespace App\Services\Shell;

class ShellCommandOption implements ShellSettingInterface
{
    protected $option;

    /**
     * @var string
     */
    protected $value;

    /**
     * ShellCommandParameter constructor.
     * @param string $option
     * @param string|null $value
     */
    public function __construct(string $option, string $value = null)
    {
        $this->option = $option;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return '--'. $this->option . ($this->value ? '=' . $this->value : '');
    }
}
