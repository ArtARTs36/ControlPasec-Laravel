<?php

use App\Models\Contragent\MyContragent;

class MyContragentSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(MyContragent::class, 'data_my_contragent');
    }
}
