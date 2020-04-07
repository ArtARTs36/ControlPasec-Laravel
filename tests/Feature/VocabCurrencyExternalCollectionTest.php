<?php

namespace Tests\Feature;

use App\Collection\VocabCurrencyExternalCollection;
use App\Models\Vocab\VocabCurrency;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabCurrencyExternalCollectionTest extends BaseTestCase
{
    public function testIterable(): void
    {
        $currencies = VocabCurrency::all()->getDictionary();
        $collection = new VocabCurrencyExternalCollection($currencies);

        foreach ($collection as $currency) {
            self::assertInstanceOf(VocabCurrency::class, $currency);
        }
    }
}
