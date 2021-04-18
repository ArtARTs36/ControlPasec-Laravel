<?php

namespace App\Based\GoBridge;

use ArtARTs36\ShellCommand\ShellCommand;

final class Executor
{
    /** @var string Путь к папке с программами Go */
    public const GO_ROOT_DIR = __DIR__ . '/../../../go-programs';

    private $programName;

    private $dirToProgram;

    private $pathToProgram;

    protected $pathToData;

    private $command;

    public function __construct(string $programName, bool $isBinary = false)
    {
        $this->programName = $programName;

        $this->dirToProgram = self::GO_ROOT_DIR . DIRECTORY_SEPARATOR . $programName;
        $this->pathToData = $this->dirToProgram . DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR;

        $this->initPathToProgram($isBinary);
        $this->initCommand($isBinary);
    }

    private function initPathToProgram(bool $isBinary): void
    {
        $this->pathToProgram = $this->dirToProgram . DIRECTORY_SEPARATOR . (($isBinary) ?
            '/bin/'. $this->programName : $this->programName . '.go');
    }

    private function initCommand(bool $isBinary): void
    {
        if ($isBinary) {
            $this->command = new ShellCommand($this->pathToProgram);
        } else {
            $this->command = (new ShellCommand('go run'))
                ->addParameter($this->pathToProgram);
        }
    }

    /**
     * Выполнить программу
     *
     * @return void
     */
    public function execute(): void
    {
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
