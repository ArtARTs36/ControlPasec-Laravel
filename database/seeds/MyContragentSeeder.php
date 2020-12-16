<?php

use App\Bundles\Contragent\Models\MyContragent;

class MyContragentSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(MyContragent::class, 'data_my_contragent');
    }
}
