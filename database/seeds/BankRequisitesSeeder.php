<?php

use App\Bundles\Contragent\Models\Contragent;
use App\Models\Contragent\BankRequisites;
use App\Models\Vocab\VocabBank;

/**
 * Class BankRequisitesSeeder
 *
 * Наполнитель для банковских реквизитов
 */
class BankRequisitesSeeder extends CommonSeeder
{
    public function run()
    {
        // todo

        if (env('APP_ENV') === 'local') {
            $this->randomData();
        }
    }

    private function randomData()
    {
        foreach ($this->getAllObjectByRelation(Contragent::class) as $contragent) {
            $requisite = new BankRequisites();
            $requisite->bank_id = $this->getRelation(VocabBank::class);
            $requisite->score = $this->faker()->bankAccountNumber;
            $requisite->contragent_id = $contragent;

            $requisite->save();
        }
    }
}
