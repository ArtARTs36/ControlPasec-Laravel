<?php

namespace App\Services\Go;

class PdfCpuGoProgram extends GoProgram
{
    const NAME = 'pdfcpu';
    const IS_BINARY = true;

    public function merge(array $files, string $savePath)
    {
        $this->getExecutor()->getCommand()
            ->addParameter('merge')
            ->addParameter($savePath)
            ->addParameters($files)
            ->execute();
    }

    protected function process()
    {
        // TODO: Implement process() method.
    }

    protected function response()
    {
        // TODO: Implement response() method.
    }
}
