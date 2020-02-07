<?php

class MyContragentSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $myContragent = new \App\Models\Contragent\MyContragent();
        $myContragent->name = 'ИП ГКФХ Украинский В Н';
        $myContragent->contragent_id = 1;
        $myContragent->save();
    }
}
