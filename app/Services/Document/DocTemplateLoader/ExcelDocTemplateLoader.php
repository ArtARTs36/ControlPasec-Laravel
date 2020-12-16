<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Support\XlsxRender;

class ExcelDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ExcelDocTemplateLoader';

    protected function make(Document $document): string
    {
        return XlsxRender::renderByDocument(
            $document,
            $this->includeData($document)
        );
    }

    /**
     * @param $documents
     * @return string
     */
    protected function makeMany($documents): string
    {
        // TODO: Implement makeMany() method.
    }
}
