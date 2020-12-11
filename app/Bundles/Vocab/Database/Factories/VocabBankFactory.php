<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabBank;
use Faker\Generator as Faker;

$factory->define(VocabBank::class, function (Faker $faker) {
    return [
        VocabBank::FIELD_SHORT_NAME => $faker->word,
        VocabBank::FIELD_FULL_NAME => $faker->word,
        VocabBank::FIELD_SCORE => $faker->bankAccountNumber,
        VocabBank::FIELD_BIK => $faker->randomNumber(),
    ];
});
