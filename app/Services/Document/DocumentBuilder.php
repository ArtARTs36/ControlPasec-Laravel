<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\Document\DocTemplateLoader\AbstractDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\ExcelDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\ManyXlxsToPdfLoader;
use App\Services\Document\DocTemplateLoader\PDFDocTemplateLoader;
use App\Services\Document\DocTemplateLoader\PhpExcelTemplateLoader;
use App\Services\Document\DocTemplateLoader\PhpWordDocTemplateLoader;

/**
 * Class DocumentBuilder
 * @package App\Services\Document
 */
class DocumentBuilder
{
    /** @var string[] */
    private const LOADERS = [
        PDFDocTemplateLoader::NAME => PDFDocTemplateLoader::class,
        ExcelDocTemplateLoader::NAME => ExcelDocTemplateLoader::class,
        PhpExcelTemplateLoader::NAME => PhpExcelTemplateLoader::class,
        PhpWordDocTemplateLoader::NAME => PhpWordDocTemplateLoader::class,
        ManyXlxsToPdfLoader::NAME => ManyXlxsToPdfLoader::class,
    ];

    /**
     * @param Document $document
     * @return string
     */
    public static function build(Document $document): string
    {
        if (empty(self::LOADERS[$document->getLoaderName()])) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        $result = $loader->load($document);

        $document->setStatusGenerated();

        return $result;
    }

    /**
     * @param array $documents
     * @return string
     */
    public static function buildMany(array $documents): string
    {
        $document = $documents[0];
        if (empty(self::LOADERS[$document->getLoaderName()])) {
            throw new \LogicException('Не найден загрузчик шаблонов!');
        }

        $loaderClass = self::LOADERS[$document->getLoaderName()];

        /** @var AbstractDocTemplateLoader $loader */
        $loader = new $loaderClass();

        return $loader->loadMany($documents);
    }
}
