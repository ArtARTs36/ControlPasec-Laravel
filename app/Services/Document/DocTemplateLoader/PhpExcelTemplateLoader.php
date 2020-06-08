<?php

namespace App\Services\Document\DocTemplateLoader;

use alhimik1986\PhpExcelTemplator\params\ExcelParam;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValue;
use alhimik1986\PhpExcelTemplator\setters\CellSetterStringValue;
use App\Models\Document\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocTemplateLoader\Adapter\ExcelFile;

class PhpExcelTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PhpExcelDocTemplateLoader';

    /**
     * @param Document $document
     * @param bool $save
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \Throwable
     */
    protected function make(Document $document, $save = false)
    {
        $fileData = $document->getTemplate() . '_data';

        $data = view($fileData, ['document' => $document])->render();
        $data = json_decode($data, true);

        $this->createFolder($docPath = DocumentService::getDownloadLink($document, true));

        return (new ExcelFile(
            $docPath,
            $document->getTemplateFullPath(true),
            $this->prepareData($data),
            $document->paper_size
        ))->save();
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
