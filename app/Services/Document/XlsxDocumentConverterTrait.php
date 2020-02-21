<?php

namespace App\Services\Document;

use App\Models\Document\DocumentExtension;
use App\Services\Shell\ShellCommand;

trait XlsxDocumentConverterTrait
{
    public static function xlsxToPdf($filePath)
    {
        self::checkFileExists($filePath);

        $outputDir = self::getDir($filePath);

        $shell = ShellCommand::getInstance('soffice', false)
            ->addOption('headless')
            ->addOption('convert-to')
            ->addParameter('pdf')
            ->addParameter($filePath)
            ->addOption('outdir')
            ->addParameter($outputDir);

        $shell = self::checkShell($shell, $filePath, DocumentExtension::PDF);

        preg_match("/->(.*) using filter/i", $shell, $matches);

        $newFilePath = self::createNewFilePath($filePath, DocumentExtension::PDF);
        if (!isset($matches[1]) || trim($matches[1]) != $newFilePath) {
            throw new DocumentConvertException($filePath, DocumentExtension::PDF);
        }

        return trim($matches[1]);
    }
}
