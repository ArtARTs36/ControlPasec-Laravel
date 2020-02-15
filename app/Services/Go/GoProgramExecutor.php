<?php

namespace App\Services\Go;

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

    /** @var string */
    private $shellResult = null;

    /** @var bool */
    private $isExecuted = false;

    /** @var array  */
    private $options = [];

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
        $this->pathToData = $this->dirToProgram . DIRECTORY_SEPARATOR . 'data';
        $this->pathToProgram = $this->dirToProgram . DIRECTORY_SEPARATOR . $programName . '.go';
    }

    /**
     * Выполнить программу
     *
     * @return string|null
     */
    public function execute()
    {
        $this->isExecuted = true;

        return shell_exec($this->prepareShellCommand());
    }

    /**
     * Добавить параметр в командную строку
     *
     * @param $value
     * @return $this
     */
    public function addParameter($value)
    {
        $this->parameters[] = $value;

        return $this;
    }

    public function addOption($value)
    {
        $this->options[] = $value;

        return $this;
    }

    /**
     * Получить путь до данных
     *
     * @return string
     */
    public function getPathToData()
    {
        return $this->pathToData;
    }

    /**
     * Получить результат выполнения программы
     *
     * @return string|null
     */
    public function getShellResult()
    {
        if ($this->shellResult === null && $this->isExecuted === false) {
            $this->execute();
        }

        return $this->shellResult;
    }

    /**
     * Подготовить шелл-команду
     *
     * @return string
     */
    private function prepareShellCommand()
    {
        $parameters = array_map(function ($parameter) {
            return '"' . $parameter . '"';
        }, $this->parameters);

        $options = array_map(function ($option) {
            return '--' . $option;
        }, $this->options);

        return implode(' ',
            array_merge(['go run', realpath($this->pathToProgram)], $parameters, $options)
        );
    }
}
