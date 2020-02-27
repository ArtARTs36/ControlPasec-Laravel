<?php

use App\Models\Vocab\SizeOfUnit;

/**
 * Class SizeOfUnitSeeder
 *
 * Наполнитель для справочника единиц измерения
 */
class SizeOfUnitSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(SizeOfUnit::class, 'data_size_of_unit');
    }
}
