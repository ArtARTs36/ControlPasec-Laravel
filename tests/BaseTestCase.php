<?php

namespace Tests;

use App\Models\Vocab\VocabQuantityUnit;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestResponse;

abstract class BaseTestCase extends TestCase
{
    /** @var Faker|null */
    protected $faker = null;

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

    protected function getFaker()
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    /**
     * @param $class
     * @return Model
     */
    protected function getRandomModel($class)
    {
        return $class::inRandomOrder()->first();
    }
}
