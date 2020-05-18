<?php

namespace Tests\Feature;

use App\Http\Controllers\ControlTime\TimeReportController;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use Tests\BaseTestCase;

class TimeReportTest extends BaseTestCase
{
    public function testByPeriod()
    {
        $employee = Employee::query()->inRandomOrder()->first();

        $response = app(TimeReportController::class)->byPeriod(
            $employee,
            Carbon::parse('15 years ago')->format('Y-m-d'),
            Carbon::now()->format('Y-m-d')
        );

        self::assertFalse(empty($response));
    }
}
