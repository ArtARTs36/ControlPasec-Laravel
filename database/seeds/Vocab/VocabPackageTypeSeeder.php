<?php

use App\Models\Vocab\VocabPackageType;

class VocabPackageTypeSeeder extends MyDataBaseSeeder
{
    public function run()
    {
        $this->fillModel(VocabPackageType::class, 'data_vocab_package_types');
        if (env('ENV_TYPE') == 'dev') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $type = new VocabPackageType();
            $type->name = $this->getFaker()->word;
            $type->save();
        }
    }
}
