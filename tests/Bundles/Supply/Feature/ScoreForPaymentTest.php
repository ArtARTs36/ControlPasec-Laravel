<?php

namespace Tests\Bundles\Supply\Feature;

use App\Models\Supply\Supply;
use Tests\BaseTestCase;

final class ScoreForPaymentTest extends BaseTestCase
{
    private const API_URL = '/api/score-for-payments';

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
