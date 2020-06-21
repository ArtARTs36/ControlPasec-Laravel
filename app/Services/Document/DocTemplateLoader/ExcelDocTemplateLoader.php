<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use App\Services\Go\XlsxRenderGoProgram;

class ExcelDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ExcelDocTemplateLoader';

    protected function make(Document $document, $save = false)
    {
        return XlsxRenderGoProgram::createByDocument(
            $document,
            $this->includeData($document)
        )->execute();
    }

    protected function makeMany($documents, $save = false)
    {
        // TODO: Implement makeMany() method.
    }
}
