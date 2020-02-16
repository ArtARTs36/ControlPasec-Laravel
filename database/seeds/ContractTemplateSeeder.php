<?php

use App\Models\Contract\ContractTemplate;

/**
 * Class ContractTemplateSeeder
 *
 * Наполнитель для образцов договоров
 */
class ContractTemplateSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(ContractTemplate::class, 'data_contract_template');

        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(35);
        }
    }

    private function randomData($count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $template = new ContractTemplate();
            $template->name = $this->getFaker()->name;
            $template->contract_title = $template->name;

            $template->save();
        }
    }
}
