<?php

namespace App\Http\Controllers\ControlTime;

use App\Http\Controllers\Controller;
use App\Http\Resource\DocumentResource;
use App\Bundles\Employee\Models\Employee;
use App\Services\ControlTime\TimeReportService;
use App\Services\Document\DocumentBuilder;
use Carbon\Carbon;

/**
 * Class TimeReportController
 * @package App\Http\Controllers\ControlTime
 */
class TimeReportController extends Controller
{
    /** @var TimeReportService */
    private $service;

    public function __construct(TimeReportService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Employee $employee
     * @param string $start
     * @param string $end
     * @return DocumentResource
     * @throws \Throwable
     */
    public function byPeriod(Employee $employee, string $start, string $end): DocumentResource
    {
        $report = $this->service->create($employee, Carbon::parse($start), Carbon::parse($end));

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
        $report = $this->service->create($employee, Carbon::parse('1 month ago'), Carbon::now());

        DocumentBuilder::build($report->document);

        return new DocumentResource($report->document);
    }
}
