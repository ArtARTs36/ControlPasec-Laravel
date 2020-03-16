<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\ScoreForPayment;
use App\Services\ScoreForPaymentService;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ScoreForPaymentTest extends BaseTestCase
{
    public function testCreate()
    {
        $currentDateTime = new \DateTime();

        $randomSupply = Supply::where('id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $score = new ScoreForPayment();

        $score->supply_id = $randomSupply->id;
        $score->date = $currentDateTime->format('Y-m-d');
        $score->save();

        self::assertTrue($score->id > 0);
    }
}
