<?php

use App\Models\Contract\ContractTemplate;

class ContractTemplateSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(ContractTemplate::class, 'data_contract_template');
    }
}
