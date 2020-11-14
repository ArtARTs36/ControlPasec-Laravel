<?php

namespace App\Services\Document;

use App\Models\Document\DocumentExtension;
use ArtARTs36\ShellCommand\ShellCommand;

trait XlsxDocumentConverterTrait
{
    public static function xlsxToPdf($filePath): string
    {
        self::checkFileExists($filePath);

        $outputDir = static::getDir($filePath);

        $shell = (new ShellCommand('soffice', false))
            ->addOption('headless')
            ->addOption('convert-to')
            ->addParameter('pdf')
            ->addParameter($filePath)
            ->addOption('outdir')
            ->addParameter($outputDir);

        static::checkShell($shell, $filePath, DocumentExtension::PDF);

        if (!file_exists($filePath)) {
            throw new DocumentConvertException($filePath, DocumentExtension::PDF);
        }

        return $filePath;
    }
}
