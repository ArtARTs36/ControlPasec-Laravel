<?php

namespace App\Bundles\Employee\Reports;

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
            __DIR__  . '/../../../../resources/views/reports/employee/controltime_period_report.xlsx'
        );
    }

    protected function prepareData(Collection $data): array
    {
        return [
            'items' => $data
            ->map(function (Time $time) {
                return [
                    'date' => $time->date,
                    'employee' => $time->employee->getFullName(),
                    'hours' => $time->getHours(),
                    'subject' => $time->subject->getFullTitle(),
                ];
            })
            ->all()];
    }
}
