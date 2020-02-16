<?php

use App\Models\Contragent;
use App\Models\Contragent\BankRequisites;
use App\Models\Vocab\VocabBank;

/**
 * Class BankRequisitesSeeder
 *
 * Наполнитель для банковских реквизитов
 */
class BankRequisitesSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        // todo

        if (env('ENV_TYPE')) {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $requisite = new BankRequisites();
            $requisite->bank_id = $this->getRelation(VocabBank::class);
            $requisite->score = $this->getFaker()->bankAccountNumber;
            $requisite->contragent_id = $this->getRelation(Contragent::class);

            $requisite->save();
        }
    }
}
