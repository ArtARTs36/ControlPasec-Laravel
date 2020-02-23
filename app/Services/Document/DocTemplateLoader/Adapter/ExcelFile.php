<?php

namespace App\Services\Document\DocTemplateLoader\Adapter;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ExcelFile
{
    /** @var string */
    private $templateFile;

    /** @var string */
    private $fileName;

    /** @var array */
    private $params;

    /** @var string */
    private $paperSize;

    /**
     * @param string $fileName
     * @param string $templateFile
     * @param array $params
     * @param string|null $paperSize
     */
    public function __construct(
        string $fileName,
        string $templateFile,
        array $params,
        string $paperSize = null
    )
    {
        $this->fileName = $fileName;
        $this->templateFile = $templateFile;
        $this->params = $params;
        $this->paperSize = $paperSize;
    }

    /**
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function save(): string
    {
        PhpExcelTemplatorAdapter::saveFileWithSpreadCallback(
            $this->templateFile,
            $this->fileName,
            $this->params,
            null,
            null,
            function (Spreadsheet $spreadsheet) {
                $spreadsheet->getActiveSheet()
                    ->getPageSetup()
                    ->setPaperSize($this->preparePaperSize());
            }
        );

        return $this->fileName;
    }

    /**
     * @return int
     */
    private function preparePaperSize(): int
    {
        $sizes = [
            'C3' => PageSetup::PAPERSIZE_C3_ENVELOPE,
            'C4' => PageSetup::PAPERSIZE_C4_ENVELOPE,
            'A3' => PageSetup::PAPERSIZE_A3,
            'A4' => PageSetup::PAPERSIZE_A4,
        ];

        return $sizes[$this->paperSize] ?? PageSetup::PAPERSIZE_LETTER;
    }
}
