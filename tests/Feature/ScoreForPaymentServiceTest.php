<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\ScoreForPayment;
use App\Services\ScoreForPaymentService;
use Tests\BaseTestCase;

class ScoreForPaymentServiceTest extends BaseTestCase
{
    public function testGetOrCreateBySupply()
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $score = ScoreForPaymentService::getOrCreateBySupply($randomSupply->id);

        self::assertInstanceOf(ScoreForPayment::class, $score);
        self::assertTrue($score->id > 0);
    }

    public function testCreateDocumentBySupply()
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $build = ScoreForPaymentService::getOrCreateDocumentBySupply($randomSupply, true);

        self::assertFileExists($build);
    }
}
