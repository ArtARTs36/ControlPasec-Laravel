<?php

namespace Tests\Bundles\Landing\Feature;

use App\Bundles\Landing\Events\FeedBackCreated;
use App\Bundles\Landing\Models\FeedBack;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

final class FeedBackTest extends BaseTestCase
{
    use WithFaker;

    private const BASE_URL = '/api/landing/feedbacks/';

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();
    }

    /**
     * @covers \App\Bundles\Landing\Http\Controllers\FeedBackController::index
     */
    public function testIndex(): void
    {
        $request = function () {
            return $this->getJson(static::BASE_URL);
        };

        $request()->assertOk();
    }

    /**
     * @covers \App\Bundles\Landing\Http\Controllers\FeedBackController::show
     */
    public function testShow(): void
    {
        $request = function (int $id) {
            return $this->getJson(static::BASE_URL . $id);
        };

        //

        $request(999)->assertNotFound();

        //

        $feedback = factory(FeedBack::class)->create();

        $request($feedback->id)->assertOk();
    }

    /**
     * @covers \App\Bundles\Landing\Http\Controllers\FeedBackController::store
     */
    public function testStore(): void
    {
        $this->expectsEvents(FeedBackCreated::class);

        $data = [
            'people_title' => $this->faker()->title,
            'people_email' => $this->faker()->email,
            'people_phone' => $this->faker()->phoneNumber,
            'ip' => $this->faker()->ipv4,
            'message' => $this->faker()->text(),
        ];

        $this
            ->postJson(self::BASE_URL, $data)
            ->assertCreated();
    }
}
