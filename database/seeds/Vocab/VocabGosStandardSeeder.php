<?php

use App\Models\Vocab\VocabGosStandard;

class VocabGosStandardSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(VocabGosStandard::class, 'data_vocab_gos_standards');
        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $standard = new VocabGosStandard();
            $standard->name = "ГОСТ ". rand(11111, 99999) . "-". rand(1111, 9999);
            $standard->description = $this->faker()->text(50);
            $standard->is_active = $this->faker()->boolean();
            $standard->date_introduction = $this->faker()->date();

            $standard->save();
        }
    }
}
