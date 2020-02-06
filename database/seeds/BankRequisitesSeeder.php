<?php

use Illuminate\Database\Seeder;

class BankRequisitesSeeder extends Seeder
{
    public function run()
    {
        $requisites = new \App\Models\Contragent\BankRequisites();
        $requisites->score = 'refreer';
        $requisites->contragent_id = 1;
        $requisites->bank_id = 1;
        $requisites->save();
    }
}
