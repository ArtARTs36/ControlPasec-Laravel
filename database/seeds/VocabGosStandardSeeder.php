<?php

use App\Models\Vocab\VocabGosStandard;

class VocabGosStandardSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(VocabGosStandard::class, 'data_vocab_gos_standards');
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $standard = new VocabGosStandard();
            $standard->name = $this->getFaker()->name();
            $standard->description = $this->getFaker()->text(50);
            $standard->is_active = $this->getFaker()->boolean();
            $standard->date_introduction = $this->getFaker()->date();

            $standard->save();
        }
    }
}
