<?php

use App\Models\Vocab\VocabQuantityUnit;

/**
 * Class VocabQuantitySeeder
 *
 * Наполнитель для справочника единиц измерения
 */
class VocabQuantityUnitSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(VocabQuantityUnit::class, 'data_vocab_quantities_units');
    }
}
