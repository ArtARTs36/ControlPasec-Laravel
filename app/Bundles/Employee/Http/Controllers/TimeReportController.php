<?php

namespace App\Bundles\Employee\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Document\Http\Resources\DocumentResource;
use App\Bundles\Employee\Models\Employee;
use App\Bundles\Employee\Services\TimeReportService;
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
     * @tag Employee
     */
    public function byPeriod(Employee $employee, string $start, string $end): DocumentResource
    {
        $report = $this->service->create($employee, Carbon::parse($start), Carbon::parse($end));

        DocumentBuilder::build($report->document);

        return new DocumentResource($report->document);
    }

    /**
     * @tag Employee
     */
    public function byLastMonth(Employee $employee)
    {
        $report = $this->service->create($employee, Carbon::parse('1 month ago'), Carbon::now());

        DocumentBuilder::build($report->document);

        return new DocumentResource($report->document);
    }
}
