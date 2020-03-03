<?php

namespace Tests\Feature;

use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;
use Tests\BaseTestCase;

class VariableDefinitionTest extends BaseTestCase
{
    public function testGetModel()
    {
        /** @var VariableDefinition $definition */
        $definition = VariableDefinition::where('model_type_id', '>', 0)
            ->inRandomOrder()
            ->get()
            ->first();

        self::assertInstanceOf(Model::class, $definition->getModel());
    }
}
