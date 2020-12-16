<?php

namespace Tests\Based\Feature;

use App\Bundles\Supply\Models\Supply;
use Carbon\Carbon;
use Tests\BaseTestCase;

final class CalendarTest extends BaseTestCase
{
    private const BASE_URL = '/api/calendar/';

    /**
     * @covers \App\Based\Http\Controllers\CalendarController::showByDates
     */
    public function testGetByDates(): void
    {
        $supply = factory(Supply::class)->make();
        $supply->planned_date = Carbon::parse('5 day ago');
        $supply->save();

        request()->merge([
            'start_date' => Carbon::parse('1 month ago')->format('Y-m-d'),
            'end_date' => Carbon::now()->format('Y-m-d'),
        ]);

        $response = $this->getJson(static::BASE_URL);

        $response->assertOk();
    }
}
