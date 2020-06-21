<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\Models\Supply\ScoreForPayment;
use App\Services\ScoreForPaymentService;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ScoreForPaymentServiceTest extends BaseTestCase
{
    public function testGetOrCreateBySupply(): void
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $score = ScoreForPaymentService::getOrCreateBySupply($randomSupply->id);

        self::assertInstanceOf(ScoreForPayment::class, $score);
        self::assertTrue($score->id > 0);
    }

    public function testCreateDocumentBySupply(): void
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $build = ScoreForPaymentService::getOrCreateDocumentBySupply($randomSupply);

        self::assertFileExists($build);
    }
}
