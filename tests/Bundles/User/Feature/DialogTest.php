<?php

namespace Tests\Bundles\User\Feature;

use App\Based\Support\RuFaker;
use App\User;
use Tests\BaseTestCase;

final class DialogTest extends BaseTestCase
{
    /**
     * @var array
     */
    protected $tokens = [];

    protected $admin;

    protected $simpleUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\RoleSeeder::class);
        $this->seed(\UserSeeder::class);

        $this->admin = User::where('name', 'admin')->first();
        $this->simpleUser = User::query()->inRandomOrder()->where('email', '<>', $this->admin->email)->first();
    }

    public function testSendAndGetMessage(): void
    {
        // send

        $text = RuFaker::getGenerator()->text(50);

        $data = [
            'to_user_id' => $this->simpleUser->id,
            'text' => $text,
        ];

        $this->actingAs($this->admin);

        $response = $this->postJson('/api/dialog-messages', $data);

        $response->assertCreated();

        $message = $this->decodeResponse($response);

        self::assertIsArray($message);

        self::assertArrayHasKey('from_user_id', $message);
        self::assertTrue($message['from_user_id'] == $this->admin->id);

        self::assertArrayHasKey('to_user_id', $message);
        self::assertTrue($message['to_user_id'] == $this->simpleUser->id);

        self::assertArrayHasKey('text', $message);
        self::assertTrue($message['text'] === $text);

        self::assertArrayHasKey('dialog_id', $message);

        $dialogId = $message['dialog_id'];

        // get

        $this->actingAs($this->simpleUser);

        $response = $this->getJson('/api/dialogs/'. $dialogId);

        $dialog = $this->decodeResponse($response);

        $response->assertOk();

        self::assertArrayHasKey('data', $dialog);
        self::assertArrayHasKey('id', $dialog['data']);
        self::assertTrue($dialog['data']['id'] === $dialogId);
        self::assertArrayHasKey('messages', $dialog['data']);

//        self::assertArrayHasKey(0, $dialog['data']['messages']);
//        self::assertArrayHasKey('text', $dialog['data']['messages'][0]);
//        self::assertTrue($dialog['data']['messages'][0]['text'] === $text);

        // get dialogs list

        $this->actingAs($this->simpleUser);

        $response = $this->get('/api/dialogs/user');

        $response->assertOk();

        $decode = $this->decodeResponse($response);

        self::assertArrayHasKey('data', $decode);

        $dialogs = $decode['data'];

        self::assertTrue(count($dialogs) > 0);

        $dialog = $dialogs[0];

        self::assertArrayHasKey('id', $dialog);
        self::assertArrayHasKey('inter_user', $dialog);
        self::assertArrayHasKey('last_message', $dialog);
        self::assertTrue(count($dialog['last_message']) > 0);

        // send to admin

        $text = RuFaker::getGenerator()->text(50);

        $data = [
            'to_user_id' => $this->admin->id,
            'text' => $text,
        ];

        $this->actingAs($this->simpleUser);

        $response = $this->postJson('/api/dialog-messages', $data);

        $response->assertCreated();
    }
}
