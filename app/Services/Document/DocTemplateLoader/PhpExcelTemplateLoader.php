<?php

namespace App\Services\Document\DocTemplateLoader;

use alhimik1986\PhpExcelTemplator\params\ExcelParam;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValue;
use alhimik1986\PhpExcelTemplator\setters\CellSetterStringValue;
use App\Bundles\Document\Models\Document;
use App\Services\Document\DocumentService;
use App\Services\Document\DocTemplateLoader\Adapter\ExcelFile;

class PhpExcelTemplateLoader extends AbstractDocTemplateLoader
{
    const NAME = 'PhpExcelDocTemplateLoader';

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function makeRaw(string $templatePath, string $savePath, array $data): bool
    {
        $this->createFolder($savePath);

        return ! empty((new ExcelFile(
            $savePath,
            $templatePath,
            $this->prepareData($data),
            'A4'
        ))->save());
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Throwable
     */
    protected function make(Document $document, $save = false): string
    {
        $this->createFolder($docPath = DocumentService::getDownloadLink($document, true));

        return (new ExcelFile(
            $docPath,
            $document->getTemplateFullPath(),
            $this->prepareData($this->includeData($document)),
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

    private function prepareData($data): array
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

    /**
     * @param Document[] $documents
     * @return string
     */
    protected function makeMany($documents): string
    {
        return '';
    }
}
