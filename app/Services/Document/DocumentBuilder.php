<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\Document\DocTemplateLoader\AbstractDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\ExcelDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\PDFDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\PhpExcelTemplateLoader;

//use App\Services\Document\DocTemplateLoader\XLSDocTemplateLoader;

class DocumentBuilder
{
    private const LOADERS = [
        PDFDocTemplateLoader::NAME => PDFDocTemplateLoader::class,
//        XLSDocTemplateLoader::NAME => XLSDocTemplateLoader::class,
        ExcelDocTemplateLoader::NAME => ExcelDocTemplateLoader::class,
        PhpExcelTemplateLoader::NAME => PhpExcelTemplateLoader::class,
    ];

    public static function build(Document $document, $save = false)
    {
        if (!self::LOADERS[$document->getLoaderName()]) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        $result = $loader->load($document, $save);

        $document->nextStatus(true);

        return $result;
    }

    public static function buildMany($documents, $save = false)
    {
        $document = $documents[0];
        if (!self::LOADERS[$document->getLoaderName()]) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        $result = $loader->loadMany($documents, $save);

        foreach ($documents as $doc) {
            $doc->nextStatus(true);
        }

        return $result;
    }
}
