<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Vocab\SizeOfUnit::class, function (Faker $faker) {
    return [
        \App\Models\Vocab\SizeOfUnit::FIELD_NAME => $faker->word,
        \App\Models\Vocab\SizeOfUnit::FIELD_NAME_EN => $faker->word,
        \App\Models\Vocab\SizeOfUnit::FIELD_OKEI => $faker->randomNumber(),
        \App\Models\Vocab\SizeOfUnit::FIELD_SHORT_NAME => $faker->word,
        \App\Models\Vocab\SizeOfUnit::FIELD_SHORT_NAME_EN => $faker->word,
    ];
});
