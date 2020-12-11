<?php

namespace App\Bundles\Document\Support;

use App\Based\GoBridge\GoProgram;

class PdfCpu extends GoProgram
{
    public const NAME = 'pdfcpu';
    protected const IS_BINARY = true;

    public function merge(array $files, string $savePath): string
    {
        $result = $this
            ->getExecutor()
            ->getCommand()
            ->addParameter('merge')
            ->addParameter($savePath)
            ->addParameters($files)
            ->getShellResult();

        if (! file_exists($savePath)) {
            throw new \RuntimeException($result);
        }

        return $savePath;
    }
}
