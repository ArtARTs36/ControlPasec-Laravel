<?php

namespace App\Services\Go;

use App\Based\GoBridge\GoProgram;

class PdfCpuGoProgram extends GoProgram
{
    public const NAME = 'pdfcpu';
    protected const IS_BINARY = true;

    public function merge(array $files, string $savePath): string
    {
        $this
            ->getExecutor()->getCommand()
            ->addParameter('merge')
            ->addParameter($savePath)
            ->addParameters($files)
            ->execute();

        return $savePath;
    }
}
