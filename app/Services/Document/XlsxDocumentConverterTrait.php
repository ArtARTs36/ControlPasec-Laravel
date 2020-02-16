<?php

namespace App\Services\Document;

use App\Models\Document\DocumentExtension;

trait XlsxDocumentConverterTrait
{
    public static function xlsxToPdf($filePath)
    {
        self::checkFileExists($filePath);

        $outputDir = self::getDir($filePath);
        $command = "soffice --headless --convert-to pdf {$filePath} --outdir {$outputDir}";

        $shellResult = self::shell($command, $filePath, DocumentExtension::PDF);

        preg_match("/->(.*) using filter/i", $shellResult, $matches);

        $newFilePath = self::createNewFilePath($filePath, DocumentExtension::PDF);
        if (!isset($matches[1]) || trim($matches[1]) != $newFilePath) {
            throw new DocumentConvertException($filePath, DocumentExtension::PDF);
        }

        return trim($matches[1]);
    }
}
