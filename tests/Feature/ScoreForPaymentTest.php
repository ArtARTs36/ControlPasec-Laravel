<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\Models\Supply\ScoreForPayment;
use App\Services\ScoreForPaymentService;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ScoreForPaymentTest extends BaseTestCase
{
    const API_URL = '/api/score-for-payments';

    /**
     * TEST POST /api/score-for-payments
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
