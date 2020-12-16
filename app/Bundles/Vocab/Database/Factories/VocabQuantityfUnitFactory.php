<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabQuantityUnit;
use Faker\Generator as Faker;

$factory->define(VocabQuantityUnit::class, function (Faker $faker) {
    return [
        VocabQuantityUnit::FIELD_NAME => $faker->word,
        VocabQuantityUnit::FIELD_NAME_EN => $faker->word,
        VocabQuantityUnit::FIELD_OKEI => $faker->randomNumber(),
        VocabQuantityUnit::FIELD_SHORT_NAME => $faker->word,
        VocabQuantityUnit::FIELD_SHORT_NAME_EN => $faker->word,
    ];
});
