<?php

namespace Tests\Bundles\Employee\Feature;

use App\Bundles\Employee\Http\Controllers\TimeReportController;
use App\Bundles\Document\Http\Resources\DocumentResource;
use App\Models\Document\Document;
use App\Bundles\Employee\Models\Employee;
use Carbon\Carbon;
use Dba\ControlTime\Models\WorkCondition;
use Tests\BaseTestCase;

final class TimeReportTest extends BaseTestCase
{
    /**
     * @covers \App\Bundles\Employee\Http\Controllers\TimeReportController::byPeriod
     * @throws \Exception
     */
    public function testByPeriod(): void
    {
        $employee = $this->getEmployee();

        $response = app(TimeReportController::class)->byPeriod(
            $employee,
            Carbon::parse('15 years ago')->format('Y-m-d'),
            Carbon::now()->format('Y-m-d')
        );

        $this->assertsForDocument($response);
    }

    /**
     * @covers \App\Bundles\Employee\Http\Controllers\TimeReportController::byLastMonth
     */
    public function testByLastMonth(): void
    {
        $employee = $this->getEmployee();

        $response = app(TimeReportController::class)->byLastMonth($employee);

        $this->assertsForDocument($response);
    }

    /**
     * @param DocumentResource $response
     */
    private function assertsForDocument(DocumentResource $response)
    {
        self::assertNotEmpty($response);
        self::assertInstanceOf(Document::class, $response->resource);
    }

    /**
     * @return Employee
     */
    private function getEmployee(): Employee
    {
        /** @var Employee $employee */
        $employee = factory(Employee::class)->create();

        /** @var WorkCondition $wc */
        $wc = factory(WorkCondition::class)->make();
        $wc->employee_id = $employee->id;
        $wc->save();

        return $employee;
    }
}
