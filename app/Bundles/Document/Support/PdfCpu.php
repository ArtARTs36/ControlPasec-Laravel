<?php

namespace App\Bundles\Document\Support;

use App\Based\GoBridge\GoProgram;
use App\Bundles\Document\Contracts\PDFUtility;

class PdfCpu extends GoProgram implements PDFUtility
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
