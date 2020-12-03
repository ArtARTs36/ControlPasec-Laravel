<?php

namespace Tests;

use App\Bundles\User\Models\Permission;
use App\Models\Vocab\VocabQuantityUnit;
use App\User;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\DB;

abstract class BaseTestCase extends TestCase
{
    use DatabaseTransactions;

    /** @var Faker|null */
    protected $faker = null;

    protected function url(string $path): string
    {
        $query = http_build_query(request()->all());

        return $path . ($query ? "?{$query}" : '');
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

    protected function actingAsUserWithPermission(string $permission): void
    {
        /** @var Permission $permission */
        $permission = Permission::findByName($permission);
        $user = \factory(User::class)->create();

        DB::table('model_has_permissions')->insert([
            'permission_id' => $permission->id,
            'model_type' => 'App/User',
            'model_id' => $user->id,
        ]);

        $this->actingAs($user);
    }

    protected function actingAsRandomUser(): void
    {
        $this->actingAs(\factory(User::class)->create());
    }
}
