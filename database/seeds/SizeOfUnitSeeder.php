<?php

class SizeOfUnitSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(\App\Models\Vocab\SizeOfUnit::class, 'data_size_of_unit');
    }
}
