<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Plant\Models\Category;
use App\Bundles\Plant\Models\Plant;
use Faker\Generator as Faker;

$factory->define(Plant::class, function (Faker $faker) {
    return [
        Plant::FIELD_NAME => $faker->unique()->word,
        Plant::FIELD_CATEGORY_ID => factory(Category::class)->create()->id,
    ];
});
