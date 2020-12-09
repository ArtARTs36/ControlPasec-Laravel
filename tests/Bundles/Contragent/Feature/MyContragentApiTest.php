<?php

namespace Tests\Bundles\Contragent\Feature;

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\MyContragent;
use Tests\BaseTestCase;

final class MyContragentApiTest extends BaseTestCase
{
    private const BASE_URL = '/api/my-contragents/';

    /**
     * @covers \App\Bundles\Contragent\Http\Controllers\MyContragentController::store
     */
    public function testStore(): void
    {
        $request = function (array $data) {
            return $this->postJson(static::BASE_URL, $data);
        };

        $request([
            MyContragent::FIELD_CONTRAGENT_ID => factory(Contragent::class)->create()->id,
            MyContragent::FIELD_NAME => 'Мой контрагент',
        ])->assertOk();
    }
}
