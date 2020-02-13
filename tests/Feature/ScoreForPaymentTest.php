<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\ScoreForPayment;
use Tests\BaseTestCase;

class ScoreForPaymentTest extends BaseTestCase
{
    public function testCreate()
    {
        $currentDateTime = new \DateTime();

        $randomSupply = Supply::find(5);

        $score = new ScoreForPayment();

        $score->supply_id = $randomSupply->id;
        $score->date = $currentDateTime->format('Y-m-d');
        $score->save();

        self::assertTrue($score->id > 0);
    }
}
