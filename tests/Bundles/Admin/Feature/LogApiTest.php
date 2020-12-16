<?php

namespace Tests\Bundles\Admin\Feature;

use Tests\BaseTestCase;

final class LogApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/security/logs';

    /**
     * @covers \App\Http\Controllers\LogController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        //

        $request()->assertOk();
    }
}
