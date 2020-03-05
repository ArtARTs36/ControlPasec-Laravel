<?php

namespace Tests\Feature;

use App\Http\Resource\ContragentGroupResource;
use App\Models\Contragent\ContragentGroup;
use Tests\BaseTestCase;

class ContragentGroupTest extends BaseTestCase
{
    const API_URL = '/api/contragent-groups';

    public function testGetAll()
    {
        $response = $this->getJson(self::API_URL);

        $response->assertStatus(200);
    }

    public function testGet()
    {
        $group = ContragentGroup::with('contragents')
            ->inRandomOrder()
            ->get()
            ->first();

        $groupResource = new ContragentGroupResource($group);

        $response = $this->getJson(self::API_URL . '/'. $group->id);
        $response->assertStatus(200);

        self::assertTrue($groupResource->toJson() === $response->getContent());
    }
}
