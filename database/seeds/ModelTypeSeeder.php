<?php

use App\Models\ModelType;

class ModelTypeSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(ModelType::class, 'data_model_types');
    }
}
