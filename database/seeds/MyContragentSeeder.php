<?php

use App\Models\Contragent\MyContragent;

class MyContragentSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(MyContragent::class, 'data_my_contragent');
    }
}
