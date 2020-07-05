<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\VocabCurrency;
use App\Support\RuFaker;
use Faker\Generator as Faker;

$factory->define(VocabCurrency::class, function (Faker $faker) {
    $name = $faker->text(10);
    $shortName = RuFaker::abbreviation($name);

    return [
        VocabCurrency::FIELD_NAME => $name,
        VocabCurrency::FIELD_SHORT_NAME => $shortName,
        VocabCurrency::FIELD_NAME_EN => $name,
        VocabCurrency::FIELD_SHORT_NAME_EN => $shortName,
        VocabCurrency::FIELD_ISO_CODE => $faker->numberBetween(),
        VocabCurrency::FIELD_ISO_SHORT_NAME => RuFaker::abbreviation($faker->text(10)),
        VocabCurrency::FIELD_SYMBOL => $faker->randomLetter,
        VocabCurrency::FIELD_PRIORITY => $faker->numberBetween(),
    ];
});
