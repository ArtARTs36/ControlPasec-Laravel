<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentConverter;
use App\Services\Document\DocumentJoiner\PDFJoiner;

/**
 * Class ManyXlxsToPdfLoader
 * @package App\Services\Document\DocTemplateLoader
 */
class ManyXlxsToPdfLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ManyXlxsToPdfLoader';

    /**
     * @param Document $document
     * @return string
     * @throws \App\Services\Document\DocumentConvertException
     */
    protected function make(Document $document): string
    {
        $document->load('children');
        if (!$document->children()->exists()) {
            return null;
        }

        return $this->makeMany($document->children);
    }

    /**
     * @param Document[] $documents
     * @return bool|false|string
     * @throws \App\Services\Document\DocumentConvertException
     */
    protected function makeMany($documents): string
    {
        $paths = [];
        foreach ($documents as $document) {
            DocumentService::buildIfNotExists($document);
            $paths[] = DocumentConverter::xlsxToPdf($document);
        }

        return (new PDFJoiner($paths))->join();
    }
}
