<?php

namespace App\Support\Archiver;

abstract class AbstractArchiver implements ArchiverInterface
{
    abstract public function compress(array $files, string $archiveName): Archive;
}
