<?php

use App\Bundles\Vocab\Models\VocabPackageType;

class VocabPackageTypeSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(VocabPackageType::class, 'data_vocab_package_types');
        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        }
    }

    private function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $type = new VocabPackageType();
            $type->name = $this->faker()->word;
            $type->save();
        }
    }
}
