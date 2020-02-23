<?php

namespace App\Services\Document\DocumentJoiner;

use App\Services\Go\GoProgramExecutor;
use App\Services\Shell\ShellCommand;

class PDFJoiner extends AbstractDocumentJoiner
{
    const OUTPUT_FILE_EXTENSION = 'pdf';
    const EXECUTOR_PATH = GoProgramExecutor::GO_ROOT_DIR . '/pdfcpu';

    public function join()
    {
        $command = ShellCommand::getInstance(self::EXECUTOR_PATH)
            ->addParameter('merge')
            ->addParameter($this->savePath);

        foreach ($this->filesPaths as $path) {
            $command->addParameter($path);
        }

        $command->execute();

        return file_exists($this->savePath) ? $this->savePath : false;
    }
}
