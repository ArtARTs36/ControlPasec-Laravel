<?php

namespace Tests\Feature\Contract;

use App\Bundles\Contract\Models\ContractTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @group NewTest
 */
final class TemplateApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_URL = '/api/contract-templates/';

    /**
     * @covers \App\Bundles\Contract\Http\Controllers\ContractTemplateController::store
     */
    public function testStore(): void
    {
        $resp = $this->postJson(static::API_URL, [
            'contract_title' => Str::random(),
            'name' => Str::random(),
        ]);

        $resp->assertCreated();
    }

    /**
     * @covers \App\Bundles\Contract\Http\Controllers\ContractTemplateController::update
     */
    public function testUpdate(): void
    {
        $template = factory(ContractTemplate::class)->create();

        $resp = $this->putJson(static::API_URL . $template->id, [
            'contract_title' => Str::random(),
            'name' => Str::random(),
        ]);

        $resp->assertOk();
    }
}
