<?php

namespace Tests\Feature\Vocab;

use App\Bundles\Vocab\Models\VocabCurrency;
use App\Bundles\Vocab\Models\VocabQuantityUnit;
use App\Models\User\Permission;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class VocabCurrencyTest extends BaseTestCase
{
    private const API_INDEX = '/api/vocab-currencies';

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabCurrencyController::store
     */
    public function testStore(): void
    {
        $data = factory(VocabCurrency::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_CURRENCIES_CREATE);

        $this->postJson(self::API_INDEX, $data)
            ->assertOk()
            ->decodeResponseJson();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabCurrencyController::show
     */
    public function testShow(): void
    {
        $currency = factory(VocabCurrency::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_CURRENCIES_VIEW);

        $this->getJson(static::API_INDEX . DIRECTORY_SEPARATOR . $currency->id)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabCurrencyController::update
     */
    public function testUpdate(): void
    {
        $currency = factory(VocabCurrency::class)->create();
        $newData = factory(VocabCurrency::class)->make()->toArray();

        $this->actingAsUserWithPermission(Permission::VOCAB_CURRENCIES_EDIT);

        $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $currency->id, $newData)
            ->assertOk();
    }

    /**
     * @covers \App\Bundles\Vocab\Http\Controllers\VocabCurrencyController::destroy()
     */
    public function testDestroy(): void
    {
        $currency = factory(VocabCurrency::class)->create();

        $this->actingAsUserWithPermission(Permission::VOCAB_CURRENCIES_DELETE);

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $currency->id)
            ->assertOk();

        self::assertNull(VocabQuantityUnit::query()->find($currency->id));
    }
}
