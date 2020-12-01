<?php

namespace Tests\Bundles\TechSupport\Feature;

use App\Bundles\TechSupport\Models\TechSupportReport;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

class TechSupportTest extends BaseTestCase
{
    use WithFaker;

    private const ROUTE_INDEX = '/api/tech-support-reports';

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();
    }

    /**
     * @covers \App\Bundles\TechSupport\Http\Controllers\TechSupportReportController::store
     */
    public function testStoreByGuest(): void
    {
        $report = [
            TechSupportReport::FIELD_AUTHOR_CONTACT => $this->faker()->phoneNumber,
            TechSupportReport::FIELD_AUTHOR_TITLE => $this->faker()->name,
            TechSupportReport::FIELD_MESSAGE => $this->faker()->text(),
        ];

        $response = $this->postJson(static::ROUTE_INDEX, $report);

        $response->assertCreated();
    }

    public function testStoreByUser(): void
    {
        $this->actingAsRandomUser();

        $report = [
            TechSupportReport::FIELD_MESSAGE => $this->faker()->text(),
        ];

        $response = $this->postJson(static::ROUTE_INDEX, $report);

        $response->assertCreated();
    }

    public function testShow(): void
    {
        $report = factory(TechSupportReport::class)->create();

        $response = $this->getJson(static::ROUTE_INDEX . DIRECTORY_SEPARATOR . $report->id);

        $response->assertOk();
    }
}
