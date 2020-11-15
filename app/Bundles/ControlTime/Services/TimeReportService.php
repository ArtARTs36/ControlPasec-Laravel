<?php

namespace App\Services\ControlTime;

use App\Models\ControlTime\TimeReport;
use App\Models\Document\DocumentType;
use App\Bundles\Employee\Models\Employee;
use App\Services\Document\DocumentCreator;

/**
 * Class TimeReportService
 * @package App\Services\ControlTime
 */
class TimeReportService
{
    /**
     * @param Employee $employee
     * @param \DateTime $start
     * @param \DateTime $end
     * @return TimeReport
     * @throws \Throwable
     */
    public function create(Employee $employee, \DateTime $start, \DateTime $end): TimeReport
    {
        $document = DocumentCreator::getInstance(DocumentType::TIME_REPORT_ID)->save();

        $report = new TimeReport();
        $report->start_date = $start->format('Y-m-d');
        $report->end_date = $end->format('Y-m-d');
        $report->document_id = $document->id;
        $report->employee_id = $employee->id;
        $report->save();

        $report->document = $document;

        return $report;
    }
}
