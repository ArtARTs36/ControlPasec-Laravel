<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use App\Services\Go\XlsxRenderGoProgram;

/**
 * Class ExcelDocTemplateLoader
 * @package App\Services\Document\DocTemplateLoader
 */
class ExcelDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ExcelDocTemplateLoader';

    /**
     * @param Document $document
     * @return string
     */
    protected function make(Document $document): string
    {
        return XlsxRenderGoProgram::createByDocument(
            $document,
            $this->includeData($document)
        )->execute();
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
