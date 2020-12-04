<?php

namespace Tests\Bundles\Supply\Feature;

use App\Models\Supply\Supply;
use Tests\BaseTestCase;

final class ScoreForPaymentTest extends BaseTestCase
{
    private const API_URL = '/api/score-for-payments';

    /**
     * @covers \App\Bundles\Supply\Http\Controllers\ScoreForPaymentController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::API_URL);
        };

        //

        $request()->assertOk();
    }

    /**
     * @covers \App\Bundles\Supply\Http\Controllers\ScoreForPaymentController::store
     */
    public function testCreate(): void
    {
        $response = $this->postJson(self::API_URL, [
            'supply_id' => $this->getRandomModel(Supply::class)->id,
            'date' => date('Y-m-d'),
        ]);

        $response->assertOk();
    }
}
