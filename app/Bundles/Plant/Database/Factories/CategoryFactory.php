<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Plant\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        Category::FIELD_NAME => $faker->unique()->word,
    ];
});
