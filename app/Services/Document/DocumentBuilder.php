<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\Document\DocTemplateLoader\AbstractDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\ExcelDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\ManyXlxsToPdfLoader;
use App\Services\Document\DocTemplateLoader\PDFDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\PhpExcelTemplateLoader;
use App\Services\Document\DocTemplateLoader\PhpWordDocTemplateLoader;

class DocumentBuilder
{
    private const LOADERS = [
        PDFDocTemplateLoader::NAME => PDFDocTemplateLoader::class,
        ExcelDocTemplateLoader::NAME => ExcelDocTemplateLoader::class,
        PhpExcelTemplateLoader::NAME => PhpExcelTemplateLoader::class,
        PhpWordDocTemplateLoader::NAME => PhpWordDocTemplateLoader::class,
        ManyXlxsToPdfLoader::NAME => ManyXlxsToPdfLoader::class,
    ];

    public static function build(Document $document, bool $save = false)
    {
        if (empty(self::LOADERS[$document->getLoaderName()])) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        $result = $loader->load($document, $save);

        $document->setStatusGenerated();

        return $result;
    }

    public static function buildMany(array $documents, bool $save = false)
    {
        $document = $documents[0];
        if (empty(self::LOADERS[$document->getLoaderName()])) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        return $loader->loadMany($documents, $save);
    }
}
