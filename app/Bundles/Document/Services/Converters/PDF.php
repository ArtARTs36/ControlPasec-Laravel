<?php

namespace App\Bundles\Document\Services\Converters;

use App\Based\Support\FileHelper;
use App\Models\Document\DocumentExtension;

class PDF extends ConsoleConverter
{
    public static function ofPath(string $path): string
    {
        return (new static())->convertOfPath($path);
    }

    /**
     * @throws \App\Bundles\Document\Exceptions\DocumentConvertFailed
     */
    public function convertOfPath(string $path): string
    {
        $cmd = $this
            ->newCommand(env('LIBRE_OFFICE_EXECUTOR', 'soffice'))
            ->addOption('headless')
            ->addOption('convert-to')
            ->addParameter('pdf')
            ->addParameter($path)
            ->addOption('outdir')
            ->addParameter($newDir = FileHelper::getDir($path));

        $this->ensureExceptionWhenCommandFailed($cmd, $path, DocumentExtension::PDF);

        return $this->createNewPath($newDir, $path);
    }

    protected function createNewPath(string $newDir, string $path): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            $newDir,
            FileHelper::getName($path),
            DocumentExtension::PDF,
        ]);
    }
}
