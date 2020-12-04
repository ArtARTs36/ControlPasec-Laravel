<?php

namespace App\Bundles\Document\Services\Converters;

use App\Services\Document\DocumentConvertException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;

abstract class ConsoleConverter
{
    protected function newCommand(string $executor): ShellCommandInterface
    {
        return new ShellCommand($executor, false);
    }

    /**
     * @throws DocumentConvertException
     */
    protected function ensureExceptionWhenCommandFailed(ShellCommandInterface $command, string $file, string $ext): void
    {
        if ($command->getShellResult() === null) {
            throw new DocumentConvertException($file, $ext);
        }
    }
}
