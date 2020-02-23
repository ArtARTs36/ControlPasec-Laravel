<?php

namespace App\Services\Document\DocTemplateLoader\Adapter;

use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;

/**
 * Class PhpExcelTemplatorAdapter
 */
class PhpExcelTemplatorAdapter extends PhpExcelTemplator
{
    /**
     * @param $templateFile
     * @param $fileName
     * @param $params
     * @param array $callbacks
     * @param array $events
     * @param callable|null $sheetCallable
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function saveFileWithSpreadCallback(
        $templateFile,
        $fileName,
        $params,
        $callbacks = [],
        $events = [],
        callable $sheetCallable = null
    )
    {
        $spreadsheet = static::getSpreadsheet($templateFile);
        if ($sheetCallable !== null) {
            $sheetCallable($spreadsheet);
        }

        $sheet = $spreadsheet->getActiveSheet();
        $templateVarsArr = $sheet->toArray();
        static::renderWorksheet($sheet, $templateVarsArr, $params, $callbacks, $events);
        static::saveSpreadsheetToFile($spreadsheet, $fileName, $events);

        return $spreadsheet;
    }
}
