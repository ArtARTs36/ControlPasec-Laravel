<?php

namespace App\Http\Controllers\ControlTime;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentResource;
use App\Models\Employee\Employee;
use App\Services\ControlTime\TimeReportService;
use App\Services\Document\DocumentBuilder;
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
        $report = TimeReportService::create($employee, Carbon::parse($start), Carbon::parse($end));

        DocumentBuilder::build($report->document);

        return new DocumentResource($report->document);
    }

    /**
     * @param Employee $employee
     * @return DocumentResource
     * @throws \Throwable
     */
    public function byLastMonth(Employee $employee)
    {
        $report = TimeReportService::create($employee, Carbon::parse('1 month ago'), Carbon::now());

        DocumentBuilder::build($report->document);

        return new DocumentResource($report->document);
    }
}
