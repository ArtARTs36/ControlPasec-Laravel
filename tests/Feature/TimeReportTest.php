<?php

namespace Tests\Feature;

use App\Http\Controllers\ControlTime\TimeReportController;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class TimeReportTest extends BaseTestCase
{
    /**
     * @throws \Exception
     */
    public function testByPeriod(): void
    {
        $employee = $this->getRandomModel(Employee::class);

        $response = app(TimeReportController::class)->byPeriod(
            $employee,
            Carbon::parse('15 years ago')->format('Y-m-d'),
            Carbon::now()->format('Y-m-d')
        );

        self::assertNotEmpty($response);
    }

    public function testByLastMonth(): void
    {
        $employee = $this->getRandomModel(Employee::class);

        $response = app(TimeReportController::class)->byLastMonth($employee);

        self::assertNotEmpty($response);
    }
}
