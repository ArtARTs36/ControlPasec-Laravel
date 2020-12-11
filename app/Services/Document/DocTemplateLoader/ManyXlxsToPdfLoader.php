<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Bundles\Document\Services\Converters\PDF;
use App\Bundles\Document\Support\PDFJoiner;
use App\Models\Document\Document;
use App\Services\Document\DocumentService;

class ManyXlxsToPdfLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ManyXlxsToPdfLoader';

    protected function make(Document $document): string
    {
        $document->load('children');
        if (! $document->children()->exists()) {
            throw new \LogicException();
        }

        return $this->makeMany($document->children);
    }

    /**
     * @param Document[] $documents
     * @return bool|false|string
     */
    protected function makeMany($documents): string
    {
        $paths = [];

        foreach ($documents as $document) {
            DocumentService::buildIfNotExists($document);
            $paths[] = PDF::ofPath($document->getFullPath());
        }

        return app(PDFJoiner::class)->joinByPaths($paths);
    }
}
