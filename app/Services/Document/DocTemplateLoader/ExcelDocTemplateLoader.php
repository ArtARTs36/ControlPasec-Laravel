<?php

namespace App\Services\Document\DocTemplateLoader;

use App\Models\Document\Document;
use App\Services\Go\XlsxRenderGoProgram;

class ExcelDocTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'ExcelDocTemplateLoader';

    protected function make(Document $document, $save = false)
    {
        $fileData = $document->getTemplate() . '_data';

        $data = view($fileData, ['document' => $document])->render();
        $data = json_decode($data, true);

        $executed = XlsxRenderGoProgram::createByDocument($document, $data)->execute();

        return $executed;
    }

    protected function makeMany($documents, $save = false)
    {
        // TODO: Implement makeMany() method.
    }
}
