<?php

use App\Bundles\Vocab\Models\VocabCurrency;

class VocabCurrencySeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(VocabCurrency::class, 'data_vocab_currencies');
    }
}
