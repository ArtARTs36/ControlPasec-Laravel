<?php

namespace Tests\Feature\ExternalNews;

use App\Bundles\ExternalNews\Models\ExternalNews;
use Tests\BaseTestCase;

/**
 * @group BaseTest
 */
class ExternalNewsTest extends BaseTestCase
{
    private const API_INDEX = '/api/external-news';

    /**
     * @covers \App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController::chart
     */
    public function testChart(): void
    {
        $this->seed(\ExternalNewsSeeder::class);

        $this->actingAsRandomUser();

        $count = rand(5, 15);
        $response = $this->getJson(static::API_INDEX . "/chart/{$count}");

        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
    }

    /**
     * @covers \App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController::update
     */
    public function testUpdate(): void
    {
        $post = factory(ExternalNews::class)->create();

        $request = [
            ExternalNews::FIELD_TITLE => $this->getFaker()->title,
            ExternalNews::FIELD_DESCRIPTION => $this->getFaker()->text(80),
        ];

        $response = $this->putJson(static::API_INDEX . DIRECTORY_SEPARATOR . $post->id, $request)
            ->assertOk()
            ->decodeResponseJson();

        //

        self::assertArrayHasKey('data', $response);
        self::assertEquals(
            $request[ExternalNews::FIELD_TITLE],
            $response['data'][ExternalNews::FIELD_TITLE]
        );
        self::assertEquals(
            $request[ExternalNews::FIELD_DESCRIPTION],
            $response['data'][ExternalNews::FIELD_DESCRIPTION]
        );
    }

    /**
     * @covers \App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController::destroy
     */
    public function testDestroy(): void
    {
        $post = factory(ExternalNews::class)->create();

        $this->deleteJson(static::API_INDEX . DIRECTORY_SEPARATOR . $post->id)
            ->assertOk();

        self::assertNull(ExternalNews::query()->find($post->id));
    }

    /**
     * @covers \App\Bundles\ExternalNews\Http\Controllers\ExternalNewsController::truncate
     */
    public function testTruncate(): void
    {
        $this->seed(\ExternalNewsSeeder::class);

        $response = $this->getJson(static::API_INDEX . "/truncate/");

        $response->assertOk();

        $count = ExternalNews::query()->count('id');

        self::assertEquals(0, $count);
    }
}
