<?php

use App\Bundles\Contract\Models\Contract;
use App\Bundles\Contract\Models\ContractTemplate;
use App\Models\Contragent;

class ContractSeeder extends CommonSeeder
{
    public function run(): void
    {
        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        }
    }

    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $contract = new Contract();
            $contract->title = $this->faker()->text(25);
            $contract->planned_date = $this->faker()->date();
            $contract->executed_date = $this->faker()->date();
            $contract->supplier_id = env('ONE_SUPPLIER_ID');
            $contract->customer_id = $this->getRelation(Contragent::class);
            $contract->template_id = $this->getRelation(ContractTemplate::class);
            $contract->save();
        }
    }
}
