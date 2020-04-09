<?php

namespace Tests\Feature;

use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VariableDefinitionTest extends BaseTestCase
{
    public function testGetModel(): void
    {
        /** @var VariableDefinition $definition */
        $definition = VariableDefinition::where('model_type_id', '>', 0)->first();

        self::assertInstanceOf(Model::class, $definition->getModel());
    }
}
