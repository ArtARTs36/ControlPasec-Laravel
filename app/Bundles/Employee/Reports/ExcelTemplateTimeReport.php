<?php

namespace App\Bundles\Employee\Reports;

use App\Services\Document\DocTemplateLoader\PhpExcelTemplateLoader;
use ArtARTs36\ControlTime\Contracts\ReportFile;
use ArtARTs36\ControlTime\Models\Time;
use ArtARTs36\ControlTime\Reports\Target\Period\PeriodReport;
use Illuminate\Support\Collection;

class ExcelTemplateTimeReport extends PeriodReport
{
    protected function makeFile(Collection $data, string $title): ReportFile
    {
        return new ExcelReportFile(
            $this,
            $title,
            $this->prepareData($data),
            __DIR__  . '/../../../../resources/reports/employee/controltime_period_report.xlsx',
            new PhpExcelTemplateLoader()
        );
    }

    /**
     * @param Collection|iterable<Time> $data
     * @return array|iterable<string, string>
     */
    protected function prepareData(Collection $data): array
    {
        $values = [];

        foreach ($data as $time) {
            $values['date'][] = $time->date;
            $values['employee'][] = $time->employee->getFullName();
            $values['hours'][] = $time->getHours();
            $values['subject'][] = $time->subject->getFullTitle();
        }

        return $values;
    }
}
