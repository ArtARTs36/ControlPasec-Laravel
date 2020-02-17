<?php

namespace App\Services\Go;

use App\Services\Shell\ShellCommand;

/**
 * Class GoProgramExecutor
 * @package App\Services\Go
 */
class GoProgramExecutor
{
    /** @var string Путь к папке с программами Go */
    const GO_ROOT_DIR = __DIR__ . '/../../../go-programs';

    /** @var string */
    private $programName;

    /** @var array */
    private $parameters = [];

    /** @var string */
    private $dirToProgram;

    /** @var string */
    private $pathToProgram;

    /** @var string */
    protected $pathToData;

    /** @var bool */
    private $isExecuted = false;

    /** @var ShellCommand */
    private $command = null;

    /**
     * GoProgramExecutor constructor.
     * @param string $programName
     * @param array|null $parameters
     */
    public function __construct(string $programName, array $parameters = null)
    {
        $this->programName = $programName;
        $this->parameters = $parameters;

        $this->dirToProgram = self::GO_ROOT_DIR . DIRECTORY_SEPARATOR . $programName;
        $this->pathToData = $this->dirToProgram . DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR;
        $this->pathToProgram = $this->dirToProgram . DIRECTORY_SEPARATOR . $programName . '.go';

        $this->initCommand();
    }

    private function initCommand(): void
    {
        $this->command = new ShellCommand('go run', false);
        $this->command->addParameter($this->pathToProgram);
    }

    /**
     * Выполнить программу
     *
     * @return string|null
     */
    public function execute()
    {
        $this->isExecuted = true;

        $this->command->execute();
    }

    /**
     * Получить путь до данных
     *
     * @return string
     */
    public function getPathToData(): string
    {
        return $this->pathToData;
    }

    /**
     * @return ShellCommand
     */
    public function getCommand(): ShellCommand
    {
        return $this->command;
    }
}
