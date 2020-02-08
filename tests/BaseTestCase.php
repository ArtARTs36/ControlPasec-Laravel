<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestResponse;

abstract class BaseTestCase extends TestCase
{
    protected function url(string $path): string
    {
        return $path . '?' . http_build_query(request()->all());
    }

    public function json($method, $uri, array $data = [], array $headers = []): TestResponse
    {
        return parent::json($method, $this->url($uri), $data, $headers);
    }

    protected function decodeResponse($response)
    {
        return json_decode($response->getContent(), true);
    }
}
