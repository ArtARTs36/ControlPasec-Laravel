<?php

namespace App\Bundles\Document\Contracts;

interface PDFUtility
{
    public function merge(array $files, string $savePath): string;
}
