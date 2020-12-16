<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bundles\Contragent\Models\ContragentGroup;
use Faker\Generator as Faker;

$factory->define(ContragentGroup::class, function (Faker $faker) {
    return [
        ContragentGroup::FIELD_NAME => $faker->word,
    ];
});
