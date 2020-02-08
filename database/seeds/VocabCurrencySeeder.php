<?php

use App\Models\Vocab\VocabCurrency;

class VocabCurrencySeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(VocabCurrency::class, 'data_vocab_currencies');
    }
}
