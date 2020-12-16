<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\SizeOfUnit;
use Faker\Generator as Faker;

$factory->define(SizeOfUnit::class, function (Faker $faker) {
    return [
        SizeOfUnit::FIELD_NAME => $faker->word,
        SizeOfUnit::FIELD_NAME_EN => $faker->word,
        SizeOfUnit::FIELD_OKEI => $faker->randomNumber(),
        SizeOfUnit::FIELD_SHORT_NAME => $faker->word,
        SizeOfUnit::FIELD_SHORT_NAME_EN => $faker->word,
    ];
});
