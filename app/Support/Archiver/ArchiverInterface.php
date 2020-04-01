<?php

namespace App\Support\Archiver;

interface ArchiverInterface
{
    const EXTENSION_ZIP = 1;

    public function compress(array $files, string $archivePath): Archive;
}
