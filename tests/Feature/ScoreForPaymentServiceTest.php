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
    /**
     * @covers \App\Services\ScoreForPaymentService::getOrCreateBySupply
     * @throws \Exception
     */
    public function testGetOrCreateBySupply(): void
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $score = ScoreForPaymentService::getOrCreateBySupply($randomSupply->id);

        self::assertInstanceOf(ScoreForPayment::class, $score);
        self::assertTrue($score->id > 0);
    }

    /**
     * @covers \App\Services\ScoreForPaymentService::getOrCreateDocumentBySupply
     * @throws \Throwable
     */
    public function testCreateDocumentBySupply(): void
    {
        /** @var Supply $randomSupply */
        $randomSupply = $this->getRandomModel(Supply::class);

        $build = ScoreForPaymentService::getOrCreateDocumentBySupply($randomSupply);

        self::assertFileExists($build);
    }
}
