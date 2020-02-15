<?php

namespace App\Services\Document\DocTemplateLoader;

use alhimik1986\PhpExcelTemplator\params\ExcelParam;
use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValue;
use alhimik1986\PhpExcelTemplator\setters\CellSetterStringValue;
use App\Models\Document\Document;
use App\Service\Document\DocumentService;

class PhpExcelTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PhpExcelDocTemplateLoader';

    protected function make(Document $document, $save = false)
    {
        $fileData = $document->getTemplate() . '_data';

        $data = view($fileData, ['document' => $document])->render();
        $data = json_decode($data, true);
        $data = $this->prepareData($data);

        $this->createFolder(DocumentService::getDownloadLink($document, true));

        PhpExcelTemplator::saveToFile(
            $document->getTemplateFullPath(true),
            DocumentService::getDownloadLink($document, true),
            $data
        );
    }

    protected function createFolder($savePath)
    {
        $parse = explode('/', $savePath);
        array_pop($parse);

        $folder = implode('/', $parse);
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }


    private function prepareData($data)
    {
        $newData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $newData[$key] = new ExcelParam(CellSetterArrayValue::class, $value);

                continue;
            }

            $newKey = "{{ $key }}";
            $newData[$newKey] = new ExcelParam(CellSetterStringValue::class, $value);
        }

        return $newData;
    }

    protected function makeMany($documents, $save = false)
    {
        // TODO: Implement makeMany() method.
    }
}
