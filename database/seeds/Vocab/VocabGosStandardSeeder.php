<?php

use App\Models\Vocab\VocabGosStandard;

class VocabGosStandardSeeder extends CommonSeeder
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
            $standard->name = "ГОСТ ". rand(11111, 99999) . "-". rand(1111, 9999);
            $standard->description = $this->getFaker()->text(50);
            $standard->is_active = $this->getFaker()->boolean();
            $standard->date_introduction = $this->getFaker()->date();

            $standard->save();
        }
    }
}
