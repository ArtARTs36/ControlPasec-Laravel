<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Vocab\Models\CurrencyCourse;
use App\Bundles\Vocab\Models\VocabCurrency;
use Faker\Generator as Faker;

$factory->define(CurrencyCourse::class, function (Faker $faker) {
    return [
        CurrencyCourse::FIELD_CURRENCY_ID => factory(VocabCurrency::class)->create()->id,
        CurrencyCourse::FIELD_NOMINAL => $faker->randomFloat(),
        CurrencyCourse::FIELD_VALUE => $faker->randomFloat(),
        CurrencyCourse::FIELD_ACTUAL_DATE => $faker->dateTime,
    ];
});
