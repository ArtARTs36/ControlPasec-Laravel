<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabCurrency;
use Faker\Generator as Faker;

$factory->define(VocabCurrency::class, function (Faker $faker) {
    return [
        VocabCurrency::FIELD_NAME => $faker->word,
        VocabCurrency::FIELD_NAME_EN => $faker->word,
        VocabCurrency::FIELD_SHORT_NAME => $faker->word,
        VocabCurrency::FIELD_SHORT_NAME_EN => $faker->word,
        VocabCurrency::FIELD_ISO_CODE => $faker->randomNumber(),
        VocabCurrency::FIELD_ISO_SHORT_NAME => (string) rand(1, 99),
        VocabCurrency::FIELD_SYMBOL => (string) rand(1, 9),
        VocabCurrency::FIELD_PRIORITY => $faker->randomNumber(),
    ];
});
