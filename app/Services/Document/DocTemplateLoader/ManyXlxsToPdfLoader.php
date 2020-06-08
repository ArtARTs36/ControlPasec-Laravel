<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocumentConverter;
use App\Services\Document\DocumentJoiner\PDFJoiner;

class ManyXlxsToPdfLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ManyXlxsToPdfLoader';

    protected function make(Document $document, $save = false)
    {
        $document->load('children');
        if (!$document->children()->exists()) {
            return null;
        }

        return $this->makeMany($document->children);
    }

    /**
     * @param Document[] $documents
     * @param bool $save
     * @return bool|false|string
     */
    protected function makeMany($documents, $save = false)
    {
        $paths = [];
        foreach ($documents as $document) {
            DocumentService::buildIfNotExists($document);
            $paths[] = DocumentConverter::xlsxToPdf($document);
        }

        $pdf = (new PDFJoiner($paths))->join();

        return $pdf;
    }
}
