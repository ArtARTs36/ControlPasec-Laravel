<?php

namespace Tests\Bundles\Contragent\Feature;

use App\Bundles\Contragent\Http\Resources\ContragentGroupResource;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Repositories\ContragentGroupRepository;
use App\Bundles\Contragent\Models\ContragentGroup;
use Tests\BaseTestCase;

final class ContragentGroupTest extends BaseTestCase
{
    private const API_URL = '/api/contragent-groups';

    /**
     * @covers \App\Bundles\Contragent\Http\Controllers\ContragentGroupController::index
     */
    public function testIndex(): void
    {
        $response = $this->getJson(static::API_URL);

        $response->assertOk();
    }

    /**
     * @covers \App\Bundles\Contragent\Http\Controllers\ContragentGroupController::show
     */
    public function testShow(): void
    {
        $request = function ($id = null) {
            return $this
                ->getJson(static::API_URL . DIRECTORY_SEPARATOR . $id);
        };

        $group = factory(ContragentGroup::class)->create();

        //

        $request($group->id)->assertOk();
    }

    public function testDetach(): void
    {
        $group = app(ContragentGroupRepository::class)->createByName($this->getFaker()->name);

        /** @var Contragent $contragent */
        $contragent = factory(Contragent::class)->create();

        $group->contragents()->attach($contragent->id);

        $url = static::API_URL . '/' . $group->id . '/detach/' . $contragent->id;

        //

        $response = $this->getJson($url)
            ->assertOk()
            ->decodeResponseJson();

        self::assertArrayHasKey('success', $response);
        self::assertTrue($response['success']);
    }

    /**
     * @covers \App\Bundles\Contragent\Http\Controllers\ContragentGroupController::store
     */
    public function testStore(): void
    {
        $request = function (array $data = []) {
            return $this->postJson(static::API_URL, $data);
        };

        $request([
            'name' => 'New Group',
        ])->assertOk();
    }
}
