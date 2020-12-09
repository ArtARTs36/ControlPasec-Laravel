<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Bundles\Vocab\Models\SizeOfUnit::class, function (Faker $faker) {
    return [
        \App\Bundles\Vocab\Models\SizeOfUnit::FIELD_NAME => $faker->word,
        \App\Bundles\Vocab\Models\SizeOfUnit::FIELD_NAME_EN => $faker->word,
        \App\Bundles\Vocab\Models\SizeOfUnit::FIELD_OKEI => $faker->randomNumber(),
        \App\Bundles\Vocab\Models\SizeOfUnit::FIELD_SHORT_NAME => $faker->word,
        \App\Bundles\Vocab\Models\SizeOfUnit::FIELD_SHORT_NAME_EN => $faker->word,
    ];
});
