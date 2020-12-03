<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contragent\Models\Contragent;
use Faker\Generator as Faker;

$factory->define(Contragent::class, function (Faker $faker) {
    return [
        Contragent::FIELD_TITLE => $faker->word,
        Contragent::FIELD_STATUS => $faker->randomNumber(),
        Contragent::FIELD_INN => rand(11111, 999999),
    ];
});
