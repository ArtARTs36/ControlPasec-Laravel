<?php

namespace Tests\Feature;

use App\Http\Resource\ContragentGroupResource;
use App\Models\Contragent\ContragentGroup;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ContragentGroupTest extends BaseTestCase
{
    const API_URL = '/api/contragent-groups';

    public function testGetAll(): void
    {
        $response = $this->getJson(self::API_URL);

        $response->assertOk();
    }

    public function testGet(): void
    {
        $group = ContragentGroup::query()
            ->with(ContragentGroup::RELATION_CONTRAGENTS)
            ->inRandomOrder()
            ->first();

        $groupResource = new ContragentGroupResource($group);

        $response = $this->getJson(static::API_URL . DIRECTORY_SEPARATOR . $group->id)
            ->assertOk();

        self::assertEquals($groupResource->toJson(), $response->getContent());
    }
}
