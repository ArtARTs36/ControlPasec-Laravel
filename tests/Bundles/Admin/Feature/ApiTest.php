<?php

namespace Tests\Bundles\Admin\Feature;

use App\Bundles\Admin\Models\VariableDefinition;
use Tests\TestCase;

final class ApiTest extends TestCase
{
    private const BASE_URL = '/api/variable-definitions/';

    /**
     * @covers \App\Bundles\Admin\Http\Controllers\VariableDefinitionController::update
     */
    public function testUpdate(): void
    {
        $request = function (int $id, array $data = []) {
            return $this->putJson(static::BASE_URL. $id, $data);
        };

        // 1. Пытаемся обновить не существующую переменную

        $request(999)->assertNotFound();

        // 2. OK

        $definition = factory(VariableDefinition::class)->create();

        $request($definition->id, [
            'value' => $value = rand(1, 950),
        ])->assertOk();

        self::assertEquals($value, $definition->refresh()->value);
    }
}
