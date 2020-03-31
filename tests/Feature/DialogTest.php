<?php

namespace Tests\Feature;

use App\User;
use Tests\BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class DialogTest extends BaseTestCase
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
        $user = User::where('name', 'admin')->first();

        \Auth::guard('api')->attempt(['email' => $user->login, 'password' => $user->password]);
        $this->admin = $user;

        $this->tokens['admin'] = JWTAuth::fromUser($this->admin);

        $this->simpleUser = User::where('email', '<>', $this->admin->email)->first();
        $this->tokens['simpleUser'] = JWTAuth::fromUser($this->simpleUser);
    }

    public function testSendAndGetMessage(): void
    {
        // send

        $text = $this->getFaker()->text;

        $data = [
            'to_user_id' => $this->simpleUser->id,
            'text' => $text,
        ];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->tokens['admin']])
            ->postJson('/api/dialog-messages', $data);

        $message = $this->decodeResponse($response);

        $response->assertCreated();

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

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->tokens['simpleUser']])
            ->get('/api/dialogs/'. $dialogId);

        $dialog = $this->decodeResponse($response);

        $response->assertOk();

        self::assertArrayHasKey('data', $dialog);
        self::assertArrayHasKey('id', $dialog['data']);
        self::assertTrue($dialog['data']['id'] === $dialogId);
        self::assertArrayHasKey('messages', $dialog['data']);
        self::assertArrayHasKey(0, $dialog['data']['messages']);
        self::assertArrayHasKey('text', $dialog['data']['messages'][0]);
        self::assertTrue($dialog['data']['messages'][0]['text'] === $text);

        $exceptedFirstMessage = $dialog['data']['messages'][0];

        // get dialogs list

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->tokens['simpleUser']])
            ->get('/api/dialogs/user');

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
    }

    public function testSendToAdmin(): void
    {
        $text = $this->getFaker()->text;

        $data = [
            'to_user_id' => $this->admin->id,
            'text' => $text,
        ];

        $response = $this
            ->withHeaders(['Authorization' => 'Bearer ' . $this->tokens['simpleUser']])
            ->postJson('/api/dialog-messages', $data);

        $response->assertCreated();
    }
}
