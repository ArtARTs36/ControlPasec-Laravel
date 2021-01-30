<?php

namespace Tests\Bundles\Vocab\Feature;

use Tests\BaseTestCase;

final class CurrencyCourseApiTest extends BaseTestCase
{
    private const BASE_URL = 'api/vocab/currency-courses';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\CurrencyCourseController::chart
     */
    public function testChart(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        dd($request()->decodeResponseJson());

        //

        $request()->assertOk();
    }
}
