<?php

use App\Models\ModelType;
use App\Models\VariableDefinition;

class VariableDefinitionSeeder extends CommonSeeder
{
    public function run()
    {
        $mapManager = new MapFindManager();
        $mapManager->add(
            ModelType::class,
            'model_type_class',
            'model_type_id',
            'class'
        );

        $this->fillModelWithMap(VariableDefinition::class, 'data_variable_definitions', $mapManager);
    }
}
