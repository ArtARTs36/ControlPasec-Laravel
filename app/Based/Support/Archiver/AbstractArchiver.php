<?php

namespace App\Based\Support\Archiver;

abstract class AbstractArchiver implements ArchiverInterface
{
    abstract public function compress(array $files, string $archivePath): Archive;
}
