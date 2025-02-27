<?php

use App\Bundles\Supply\Models\ContractTemplate;

/**
 * Class ContractTemplateSeeder
 *
 * Наполнитель для образцов договоров
 */
class ContractTemplateSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(ContractTemplate::class, 'data_contract_template');

        if (env('APP_ENV') == 'local') {
            $this->randomData(35);
        }
    }

    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $template = new ContractTemplate();
            $template->name = $this->faker()->name;
            $template->contract_title = $template->name;

            $template->save();
        }
    }
}
