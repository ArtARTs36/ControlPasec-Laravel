<?php

namespace Tests\Based\Feature;

use Illuminate\Routing\Route;
use Tests\TestCase;

final class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
