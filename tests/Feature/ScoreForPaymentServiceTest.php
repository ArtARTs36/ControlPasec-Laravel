<?php

namespace Tests\Feature;

use App\Models\Supply\Supply;
use App\Services\ScoreForPaymentService;
use Tests\BaseTestCase;

class ScoreForPaymentServiceTest extends BaseTestCase
{
    public function testGetOrCreateBySupply()
    {
        $randomSupply = Supply::where('supplier_id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $score = ScoreForPaymentService::getOrCreateBySupply($randomSupply->id);

        self::assertTrue($score->id > 0);
    }

    public function testCreateDocumentBySupply()
    {
        /** @var Supply $randomSupply */
        $randomSupply = Supply::where('supplier_id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        $build = ScoreForPaymentService::getOrCreateDocumentBySupply($randomSupply, true);

        self::assertFileExists($build);
    }
}
