<?php

use Illuminate\Database\Seeder;

class VocabBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = new \App\Models\Vocab\VocabBank();
        $bank->short_name = 'ПАО Сбербанк';
        $bank->full_name = 'Публичное акционерное общество «Сбербанк России»';
        $bank->bik = 044525225;
        $bank->score = '30101810400000000225';
        $bank->save();

    }
}
