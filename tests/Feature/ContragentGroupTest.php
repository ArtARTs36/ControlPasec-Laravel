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
        $group = ContragentGroup::with('contragents')
            ->inRandomOrder()
            ->first();

        $groupResource = new ContragentGroupResource($group);

        $response = $this->getJson(self::API_URL . '/'. $group->id);
        $response->assertOk();

        self::assertTrue($groupResource->toJson() === $response->getContent());
    }
}
