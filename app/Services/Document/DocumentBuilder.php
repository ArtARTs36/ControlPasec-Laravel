<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\Document\DocTemplateLoader\AbstractDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\PDFDocTemplateLoader;
//use App\Services\Document\DocTemplateLoader\XLSDocTemplateLoader;

class DocumentBuilder
{
    private const LOADERS = [
        PDFDocTemplateLoader::NAME => PDFDocTemplateLoader::class,
//        XLSDocTemplateLoader::NAME => XLSDocTemplateLoader::class
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
}
