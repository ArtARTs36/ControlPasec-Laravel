<?php

namespace App\Http\Controllers\ControlTime;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentResource;
use App\Models\ControlTime\TimeReport;
use App\Models\Document\DocumentType;
use App\Models\Employee\Employee;
use App\Services\Document\DocumentBuilder;
use App\Services\Document\DocumentCreator;
use Carbon\Carbon;

class TimeReportController extends Controller
{
    /**
     * @param Employee $employee
     * @param string $start
     * @param string $end
     * @return DocumentResource
     * @throws \Throwable
     */
    public function byPeriod(Employee $employee, string $start, string $end): DocumentResource
    {
        $document = DocumentCreator::getInstance(
            DocumentType::where('template', 'document_time_report')->first()
        )->save();

        $report = new TimeReport();
        $report->start_date = Carbon::parse($start);
        $report->end_date = Carbon::parse($end);
        $report->document_id = $document->id;
        $report->employee_id = $employee->id;
        $report->save();

        DocumentBuilder::build($document, true);

        return new DocumentResource($document);
    }
}
